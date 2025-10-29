<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Start with a clean slate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Jadwal::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Get necessary data
        $mataKuliahs = MataKuliah::all();
        $dosens = User::where('role', 'dosen')->get();

        if ($dosens->isEmpty() || $mataKuliahs->isEmpty()) {
            $this->command->info("Please ensure you have seeded both MataKuliah and Dosen (users with role 'dosen') before running this seeder.");
            return;
        }

        // 3. Define schedule parameters
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $timeSlots = [
            ['start' => '07:00', 'end' => '09:00'],
            ['start' => '09:00', 'end' => '11:00'],
            ['start' => '11:00', 'end' => '13:00'],
            ['start' => '13:00', 'end' => '15:00'],
            ['start' => '15:00', 'end' => '17:00'],
        ];
        $rooms = ['R-01', 'R-02', 'R-03', 'R-04', 'R-05', 'LAB-A', 'LAB-B'];
        $tahunAkademik = '2024/2025';

        // 4. Keep track of what's been scheduled
        $scheduledSlots = [];

        // 5. Loop through each course and assign a schedule systematically
        $this->command->info('Generating schedules for all mata kuliah...');
        foreach ($mataKuliahs as $mataKuliah) {
            $scheduleCreated = false;

            // Shuffle collections to introduce randomness in assignment
            $shuffledDays = collect($days)->shuffle();
            $shuffledTimeSlots = collect($timeSlots)->shuffle();
            $shuffledRooms = collect($rooms)->shuffle();
            $shuffledDosens = $dosens->shuffle();

            foreach ($shuffledDays as $day) {
                foreach ($shuffledTimeSlots as $timeSlot) {
                    // Check if the semester group already has a class at this time
                    $semesterSlotKey = "{$day}-{$timeSlot['start']}-{$mataKuliah->semester}";
                    if (isset($scheduledSlots[$semesterSlotKey])) {
                        continue; // This semester group is busy, try next time slot
                    }

                    foreach ($shuffledRooms as $room) {
                        // Check if the room is already booked at this time
                        $roomSlotKey = "{$day}-{$timeSlot['start']}-{$room}";
                        if (isset($scheduledSlots[$roomSlotKey])) {
                            continue; // This room is busy, try next room
                        }

                        foreach ($shuffledDosens as $dosen) {
                            // Check if this specific lecturer is busy at this time
                            $dosenSlotKey = "{$day}-{$timeSlot['start']}-{$dosen->id}";
                            if (isset($scheduledSlots[$dosenSlotKey])) {
                                continue; // This lecturer is busy, try next lecturer
                            }

                            // --- Found a free combination! ---
                            Jadwal::create([
                                'mata_kuliah_id' => $mataKuliah->id,
                                'dosen_id' => $dosen->id,
                                'hari' => $day,
                                'waktu_mulai' => $timeSlot['start'],
                                'waktu_selesai' => $timeSlot['end'],
                                'ruangan' => $room,
                                'semester' => $mataKuliah->semester,
                                'tahun_akademik' => $tahunAkademik,
                            ]);

                            // Mark all relevant slots as taken
                            $scheduledSlots[$semesterSlotKey] = true;
                            $scheduledSlots[$roomSlotKey] = true;
                            $scheduledSlots[$dosenSlotKey] = true;

                            $scheduleCreated = true;
                            goto nextMataKuliah; // Jump to the next mata kuliah
                        }
                    }
                }
            }

            nextMataKuliah:
            if (!$scheduleCreated) {
                $this->command->warn("Could not find any available schedule slot for: {$mataKuliah->nama_mk}");
            }
        }

        $this->command->info('JadwalSeeder finished.');
    }
}

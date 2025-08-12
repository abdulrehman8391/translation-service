<?php

namespace App\Console\Commands; use Illuminate\Console\Command; use Illuminate\Support\Facades\DB;

class SeedTranslations extends Command { protected $signature='translations:seed {--count=100000}'; protected $description='Seed translations in bulk'; public function handle(): int { $count=(int)$this->option('count'); $batch=5000; $created=0; DB::connection()->disableQueryLog(); while($created<$count){ $to=min($batch,$count-$created); $rows=[]; for($i=0;$i<$to;$i++){ $key='app.'.bin2hex(random_bytes(6)).'.'.($created+$i); $locale=['en','fr','es','de','ur'][array_rand(['en','fr','es','de','ur'])]; $rows[]=['key'=>$key,'locale'=>$locale,'value'=>'Sample for '.$key,'tags'=>json_encode(['web','mobile']),'context'=>'web','created_at'=>now(),'updated_at'=>now()]; } DB::transaction(function()use($rows){ DB::table('translations')->insert($rows); }); $created += $to; $this->info("Inserted {$created}"); } $this->info('Done'); return 0; } }

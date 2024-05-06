<?php

namespace App\Console\Commands;

use App\Models\CopyAccount;
use Illuminate\Console\Command;

class BcryptColumnData extends Command
{
    protected $signature = 'bcrypt:column {varPassword} {--model=CopyAccount}';

    protected $description = 'Bcrypt all the data in a specified column';

    public function handle()
    {
        $column = $this->argument('varPassword');
        $modelName = $this->option('model');
        $model = app("App\Models\\$modelName");

        $records = $model->all();

        foreach ($records as $record) {
            $value = $record->{$column};
            $hashedValue = bcrypt($value);

            $record->{$column} = $hashedValue;
            $record->save();
        }

        $this->info("All data in column '$column' has been bcrypt hashed. Command completed successfully.");
        \Illuminate\Support\Facades\Log::info("All data in column '$column' has been bcrypt hashed. Command completed successfully.");
    }
}

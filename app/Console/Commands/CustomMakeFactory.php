<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Factories\FactoryMakeCommand as BaseFactoryMakeCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * CustomMakeFactory.
 */
class CustomMakeFactory extends BaseFactoryMakeCommand
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        parent::handle();
        return 0;
    }

    /**
     * getOptions.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        $options[] = ['faker', 'f', null, 'Add fillable properties with faker values'];
        return $options;
    }

    /**
     * buildClass.
     *
     * @param  mixed $name
     * @return string
     */
    protected function buildClass($name)
    {
        if ($this->option('faker') && $this->option('model')) {
            $modelClass = 'App\\'.Str::studly($this->option('model')); // Model class name
            $fillableFields = (new $modelClass())->getFillable(); // Get all fillable fields declared in the model
            $tableName = (new $modelClass())->getTable(); // Get table Name

            $line = '';
            foreach ($fillableFields as $fieldName) {
                // Getting the coulmn type based on table name and
                $columnType = DB::getSchemaBuilder()->getColumnType($tableName, $fieldName);

                switch ($columnType ?? '') {
                    case 'varchar':
                    case 'string':
                        $faker = '$faker->word';
                        break;
                    case 'integer':
                        $faker = '$faker->number';
                        break;
                    case 'boolean':
                        $faker = '$faker->boolean';
                        break;
                    case 'date':
                        $faker = '$faker->date';
                        break;
                    default:
                        $faker = '$faker->word';
                }
                $line .= "'$fieldName' => $faker,\n\t\t";
            }
            //replace // with generated mapped fieldname with faker values
            return str_replace('//', $line, parent::buildClass($name));
        }
        // call parent class method.
        return parent::buildClass($name);
    }
}

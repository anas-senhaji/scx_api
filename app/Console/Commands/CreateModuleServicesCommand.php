<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleServicesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:services {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Service and Resources inside a module.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleName = $this->argument('name');
        $modulePath = base_path('app/Modules/' . $moduleName);
        $servicesPath = $modulePath . '/Services';

        if (!file_exists($servicesPath)) {
            mkdir($servicesPath, 0777, true);
        }

        $servicesClass = <<<CLASS
<?php

namespace App\Modules\\$moduleName\Services;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Modules\\$moduleName\Models\\$moduleName;

class {$moduleName}Service
{
    use CustomResponse;
    //
}
CLASS;

        file_put_contents($servicesPath . '/' . $moduleName . 'Service.php', $servicesClass);

        $this->info('The services folder and class have been created.');

        $moduleName = $this->argument('name');
        $modulePath = base_path('app/Modules/' . $moduleName);
        $resourcesPath = $modulePath . '/Http/Resources';

        if (!file_exists($resourcesPath)) {
            mkdir($resourcesPath, 0777, true);
        }

        $collectionClass = <<<CLASS
<?php

namespace App\Modules\\$moduleName\Http\Resources;
use App\Http\Resources\BaseResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class {$moduleName}Collection extends BaseResourceCollection
{
    public function __construct(\$resource)
    {
        parent::__construct(\$resource);
    }
}
CLASS;

        file_put_contents($resourcesPath . '/' . $moduleName . 'Collection.php', $collectionClass);

        $this->info('The resource folder and resource collection have been created.');

        $resourceClass = <<<CLASS
<?php

namespace App\Modules\\$moduleName\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class {$moduleName}Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\$request)
    {
        return [
            'id' => \$this->id,
            'uuid' => \$this->uuid,
            'created_at' => \$this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => \$this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
CLASS;
        
                file_put_contents($resourcesPath . '/' . $moduleName . 'Resource.php', $resourceClass);
        
                $this->info('The resource have been created.');
    }
}

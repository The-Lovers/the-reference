<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Créer un repository qui étend ResourceRepository et crée le modèle si nécessaire';

    public function handle()
    {
        $repoName = Str::studly($this->argument('name')); // ex: UserRepository

        // Déduire le modèle automatiquement
        if (Str::endsWith($repoName, 'Repository')) {
            $model = Str::substr($repoName, 0, -10); // retirer "Repository"
        } else {
            $model = $repoName;
        }
        $model = Str::studly($model);

        $repositoryDir  = app_path('Repositories');
        $repositoryPath = "{$repositoryDir}/{$repoName}.php";

        // Créer le dossier Repositories si nécessaire
        if (!File::exists($repositoryDir)) {
            File::makeDirectory($repositoryDir, 0755, true);
            $this->info("📁 Dossier Repositories créé");
        }

        // Créer le modèle s’il n’existe pas
        if (!class_exists("App\\Models\\{$model}")) {
            $this->call('make:model', ['name' => $model]);
            $this->info("📦 Modèle {$model} créé automatiquement");
        }

        // Vérifier si le repository existe déjà
        if (File::exists($repositoryPath)) {
            $this->error("❌ {$repoName} existe déjà");
            return Command::FAILURE;
        }

        // Créer le repository
        File::put($repositoryPath, $this->repositoryStub($repoName, $model));
        $this->info("✔ {$repoName} créé avec succès, utilisant le modèle {$model}");

        return Command::SUCCESS;
    }

    protected function repositoryStub(string $repoName, string $model): string
    {
        return <<<PHP
        <?php

        namespace App\Repositories;

        use App\Models\\{$model};

        class {$repoName} extends ResourceRepository
        {
            public function __construct({$model} \$model)
            {
                parent::__construct(\$model);
            }

            public function getAll()
            {
                return \$this->model->all();
            }

            public function getById(int \$id): ?{$model}
            {
                return \$this->model->find(\$id);
            }

        }
        PHP;
    }
}

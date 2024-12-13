<?php

namespace Src\View;

use Src\Filesystem\Filesystem;
use Src\Foundation\Application;
use Src\Session\Flash;
use Src\Validation\Validation;

use function Src\Helpers\flash;

final class View
{
    public function __construct(
        private Application $app,
        private Filesystem $filesystem,
        private Template $template
    ) {}

    public function render($view, $data = [])
    {
        $file = $this->template->parse(
            $this->filesystem->readFile($this->app['views.base'] . $view . '.html')
        );

        $cached = $this->app['views.cache'] . $view . '.php';
        
        $cacheDir = $this->filesystem->dirname($cached);

        $this->filesystem->mkdir($cacheDir);
        $this->filesystem->writeFile($cached, $file);

        $data['view_form_err'] = flash()->get(Validation::VALIDATE_ERR_MESSAGES);
        $data['view_form_data'] = flash()->get(Validation::VALIDATE_FORM_DATA);
        $data['view_has_form_err'] = flash()->get(Validation::VALIDATE_HAS_ERROR);
        $data['view_flash_message'] = flash()->get(Flash::MESSAGE);
        $data['view_flash_success'] = flash()->get(Flash::STATUS);

        foreach($data as $key => $value) {
            $$key = $value;
        }

        require $cached;
    }
}
<?php
// Tony Silvestri
// 11/4/21

declare(strict_types=1);

namespace Homework;

include ("Cache.php");
include ("ShippingRates.php");

class Application
{
    public function run(): void
    {
        $results = null;
        if (!empty($_POST)) {
            $cache = new Cache();
            $service = new ShippingRates($cache);
            $results = $service->GetShippingRate();
        }
        echo $this->renderView('views/form.php', ['results' => $results]);
   }

    public function renderView(string $filePath, array $variables = []): string
    {
        ob_start();
        extract($variables, EXTR_OVERWRITE);
        include($filePath);

        return ob_get_clean();
    }
}

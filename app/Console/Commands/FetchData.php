<?php

namespace App\Console\Commands;

use App\Stock;
use App\StockAttribute;
use App\StockValue;
use App\Traits\HttpRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchData extends Command
{
    use HttpRequest;

    protected $stockConfig;

    /**
     * @var string[]
     */
    protected $ticketAttr = ['idcp', 'ticker', 'url', 'nazov'];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:stocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Stocks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->stockConfig = config('services.finscreener');
    }

    /**
     * @return void
     */
    public function handle()
    {

        //get Idcp to get the stocks
        $idcps = $this->getIdcps();

        if (sizeof($idcps) > 0) {

            $response = $this->_post($this->stockConfig['get_stock_url'], $this->stockRequest($idcps));

            $data = json_decode($response->body());

            foreach ($data->zoznamCennychPapierov as $ticker) {
                if (!empty($ticker)) {
                    $this->storeTicker($ticker);
                }
            }
        } else {
            Log::info('Error ! Incorrect IDCPS');
        }
    }

    /**
     * @return array
     */

    public function getIdcps()
    {
        $res = $this->_get($this->stockConfig['get_idcp_url']);

        if (!empty($res)) {
            $idcps = [];

            foreach (json_decode($res->body()) as $obj) {
                $idcps[] = $obj->idcp;
            }

            return $idcps;
        }
        return [];
    }

    /**
     * @param $data
     * @return void
     */
    public function storeTicker($data)
    {
        $stock = Stock::updateOrcreate([
            'idcp' => $data->idcp,
        ], [
            'ticker' => $data->ticker,
            'name' => $data->nazov,
            'url' => $data->url,
        ]);

        $this->storeAttributes($data, $stock->id);
    }

    /**
     * @param $attributes
     * @param $stockId
     * @return void
     */

    public function storeAttributes($attributes, $stockId)
    {
        foreach ($attributes as $key => $attribute) {

            if (!in_array($key, $this->ticketAttr)) {
                if ($key == 'performances') {
                    foreach ($attribute as $performance) {
                        $getAttr = StockAttribute::updateOrcreate([
                            'name' => $key . '-' . $performance->mesiacovDozadu,
                        ], ['performance_month' => $performance->mesiacovDozadu]);

                        $this->storeValues($performance->hodnota, $stockId, $getAttr->id);
                    }
                } else {
                    $getAttr = StockAttribute::updateOrcreate([
                        'name' => $key
                    ], []);

                    $this->storeValues($attribute, $stockId, $getAttr->id);
                }
            }
        }
    }

    /**
     * @param $value
     * @param $stockId
     * @param $attrId
     * @return void
     */

    public function storeValues($value, $stockId, $attrId)
    {
        StockValue::updateOrcreate([
            'stock_id' => $stockId,
            'stock_attribute_id' => $attrId,
        ], [
            'value' => $value
        ]);
    }

    /**
     * @param $idcps
     * @return array
     */

    public function stockRequest($idcps)
    {
        return [
            'typTabulky' => "OverBought",
            'idu' => -1,
            "zoradenie" => [
                'idStlpca' => 4,
                'vzostupne' => false
            ],
            "strankovanie" => [
                'cisloStranky' => 1,
                'pocetZaznamovNaStranku' => 100
            ],
            'idcps' => $idcps,
        ];
    }
}

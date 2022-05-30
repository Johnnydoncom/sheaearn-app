<?php

namespace App\Http\Livewire\Account;

use Illuminate\Support\Carbon;
use Livewire\Component;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\RadarChartModel;
use Asantibanez\LivewireCharts\Models\TreeMapChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Account extends Component
{
    public $salesEarning, $socialEarning, $allTimeEarning;

    public $colors = [
        'deposit' => '#f6ad55',
        'withdraw' => '#fc8181',
        'entertainment' => '#90cdf4',
        'travel' => '#66DA26',
        'other' => '#cbd5e0',
    ];

    public $firstRun = true;
    public $showDataLabels = true;

    public $canWithDrawSalesEarning = false;

    public function mount()
    {
        auth()->user()->wallet->refreshBalance();
        // auth()->user()->socialWallet->refreshBalance();

//        auth()->user()->socialWallet()->deposit(15);
//        auth()->user()->deposit(20);

        $this->salesEarning = auth()->user()->wallet->balance;
        $this->socialEarning = auth()->user()->socialWallet()->balance;

        $this->allTimeEarning = auth()->user()->transactions()->where('type', '=', 'deposit')->get()->sum('amount');

        $today = new Carbon();
        if($today->dayOfWeek == Carbon::MONDAY){
            $this->canWithDrawSalesEarning = true;
        }
    }

    public function render()
    {
        $income = auth()->user()->transactions()->get();

        $columnChartModel = $income->groupBy('type')
            ->reduce(function ($columnChartModel, $data) {
                $type = $data->first()->type;
                $value = $data->sum('amount');

                return $columnChartModel->addColumn($type, $value, $this->colors[$type]);
            }, LivewireCharts::columnChartModel()
                ->setTitle('Expenses by Type')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
                ->setLegendVisibility(true)
                ->setDataLabelsEnabled($this->showDataLabels)
                //->setOpacity(0.25)
                ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665'])
                ->setColumnWidth(90)
                ->withGrid()
            );

            $areaChartModel = $income
            ->reduce(function ($areaChartModel, $data) use ($income) {
                $type = $data->first()->type;
                // $tx = $data->first();
                // $type = $tx->type === 'deposit' ? 'Income' : 'Withdraw';
                return $areaChartModel->addPoint($data->created_at->format('F j, Y h:i'), $data->amount, ['id' => $data->id])->setXAxisVisible(true)->setYAxisVisible(true)->setTitle($data->amount);
            }, LivewireCharts::areaChartModel()
                ->setTitle('Transactions History')
                ->setAnimated($this->firstRun)
                ->setColor('#f6ad55')
                // ->withDataLabels(true)
                ->withLegend()
                // ->withOnPointClickEvent('onAreaPointClick')
                // ->setDataLabelsEnabled($this->showDataLabels)
                ->setXAxisVisible(false)
                ->setYAxisVisible(true)
                ->sparklined()
            );


        return view('livewire.account.account')->layout('layouts.account')->with([
            'columnChartModel' => $columnChartModel,
            'areaChartModel' => $areaChartModel
        ]);
    }
}

<div class="card p-3">
    <?php
        // accesing all the devices and total value
        $devices = array();
        foreach($analytics as $item){
            array_push($devices, $item->device);
        };

        // calculating that how many devices;
        $deviceCounted=array_count_values($devices);        
    ?>

    <h4 class="m-0">{{__('Devices')}}</h4>
    @foreach($deviceCounted as $device=>$count)
        <?php
            $totalWindows = abs(($count * 100 / count($devices)));
        ?>
        <div class="my-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="m-0">{{$device}}</p>
                </div>
                <div>
                    <span style="font-size: 13px">{{round($totalWindows)}}%</span>
                    <span style="padding-left: 16px">{{$count}}</span>
                </div>
            </div>
            <div class="progress" style="height: 8px">
                <div class="progress-bar" role="progressbar" style="width: {{round($totalWindows)}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    @endforeach
</div>
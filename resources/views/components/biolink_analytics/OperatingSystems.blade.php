<div class="card p-3">
    <?php
        // accesing all the platform and total value
        $os = array();
        foreach($analytics as $item){
            array_push($os, $item->platform);
        };

        // calculating that how many platform;
        $deviceCounted=array_count_values($os);
    ?>

    <h4 class="m-0">{{__('Operating Systems')}}</h4>
    @foreach($deviceCounted as $device=>$count)
        <?php
            $totalWindows = abs(($count * 100 / count($os)));
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
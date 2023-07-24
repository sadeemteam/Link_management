<div class="card p-3">
    <?php
        // accesing all the referer and total value
        $referer = array();
        foreach($analytics as $item){
            array_push($referer, $item->referer);
        };

        // calculating that how many referer;
        $refererCounted=array("Refer"=>0, "Direct"=>0);

        for($i=0; $i<count($referer); $i++) {
            $key=$referer[$i];
            
            if ($key) {
                $refererCounted["Refer"]++;
            } else {
                $refererCounted["Direct"]++;
            };
        };
    ?>

    <h4 class="m-0">{{__('Referrers')}}</h4>
    @foreach($refererCounted as $key=>$value)
        @if($key == 'Refer' && $value > 0 || $key == 'Direct' && $value > 0)
            <?php
                $totalReferer = abs(($value * 100 / count($referer)));
            ?>
            <div class="my-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="m-0">{{$key}}</p>
                    </div>
                    <div>
                        <span style="font-size: 13px">{{round($totalReferer)}}%</span>
                        <span style="padding-left: 16px">{{$value}}</span>
                    </div>
                </div>
                <div class="progress" style="height: 8px">
                    <div class="progress-bar" role="progressbar" style="width: {{round($totalReferer)}}%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        @endif
        
    @endforeach
</div>
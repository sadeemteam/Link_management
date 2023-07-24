<div class="card p-3">
    <?php
        // accesing all the browsers and total value
        $countries = array();
        foreach($analytics as $item){
            $country = json_decode($item->ip)->countryName;
            array_push($countries, $country);
        };

        // calculating that how many countries; 
        $countryCounted=array_count_values($countries);
    ?>

    <h4 class="m-0">{{__('Countries')}}</h4>
    @foreach($countryCounted as $country=>$count)
        <?php
            $totalCountry = abs(($count * 100 / count($countries)));
        ?>
        <div class="my-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="m-0">{{$country}}</p>
                </div>
                <div>
                    <span style="font-size: 13px">{{round($totalCountry)}}%</span>
                    <span style="padding-left: 16px">{{$count}}</span>
                </div>
            </div>
            <div class="progress" style="height: 8px">
                <div class="progress-bar" role="progressbar" style="width: {{round($totalCountry)}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    @endforeach
</div>
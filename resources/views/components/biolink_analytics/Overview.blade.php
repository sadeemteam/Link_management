<div class="row">
    <div class="col-lg-6 my-3">
        <div class="card p-3 h-100">
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
            @if ($link && $link->id)
                <a class="text-decoration-none" href="/dashboard/biolink/analytics/{{$link->id}}/countries">View More</a>
            @endif
        </div>
    </div>
    <div class="col-lg-6 my-3">
        <div class="card p-3 h-100">
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

            <h4 class="m-0">Referrers</h4>
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
            @if ($link && $link->id)
                <a class="text-decoration-none" href="/dashboard/biolink/analytics/{{$link->id}}/referrers">View More</a>
            @endif
        </div>
    </div>
    <div class="col-lg-6 my-3">
        <div class="card p-3 h-100">
            <?php
                // accesing all the devices and total value
                $devices = array();
                foreach($analytics as $item){
                    array_push($devices, $item->device);
                };

                // calculating that how many devices;
                $deviceCounted=array_count_values($devices);        
            ?>

            <h4 class="m-0">Devices</h4>
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
            @if ($link && $link->id)
                <a class="text-decoration-none" href="/dashboard/biolink/analytics/{{$link->id}}/devices">View More</a>
            @endif
        </div>
    </div>
    <div class="col-lg-6 my-3">
        <div class="card p-3 h-100">
            <?php
                // accesing all the platform and total value
                $os = array();
                foreach($analytics as $item){
                    array_push($os, $item->platform);
                };

                // calculating that how many platform;
                $deviceCounted=array_count_values($os);
            ?>
        
            <h4 class="m-0">Operating Systems</h4>
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
            @if ($link && $link->id)
                <a 
                    class="text-decoration-none" 
                    href="/dashboard/biolink/analytics/{{$link->id}}/operating-systems"
                >
                    View More
                </a>
            @endif
        </div>
    </div>

    <div class="col-lg-6 my-3">
        <div class="card p-3 h-100">
            <?php
                // accesing all the browsers and total value
                $browers = array();
                foreach($analytics as $item){
                    array_push($browers, $item->browser);
                };

                // calculating that how many browsers;
                $browserCounted=array_count_values($browers);
            ?>

            <h4 class="m-0">Browers</h4>
            @foreach($browserCounted as $browser=>$count)
                <?php
                    $totalWindows = abs(($count * 100 / count($browers)));
                ?>
                <div class="my-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="m-0">{{$browser}}</p>
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
            @if ($link && $link->id)
                <a class="text-decoration-none" href="/dashboard/biolink/analytics/{{$link->id}}/browsers">View More</a>
            @endif
        </div>
    </div>
    <div class="col-lg-6 my-3">
        <div class="card p-3 h-100">
            <?php
                // accesing the language codes and total value
                $lanCodes = array();
                foreach($analytics as $item){
                    $lan = json_decode($item->languages);
                    array_push($lanCodes, $lan[1]);
                };
                
                // calculating that how many lanCode;
                $languagesCounted=array_count_values($lanCodes);

                function getLanName1 ($languages, $code) {
                    $lan_name = '';
                    foreach ($languages as $lan) {
                        if ($lan->code == $code) {
                        $lan_name = $lan->name;
                        }
                    };
                   
                    return $lan_name;
                };

                // Generating the language name by language cody
                $language_names=array();
                foreach ($languagesCounted as $key=>$value) {
                    $lan = getLanName1($languages, $key);
                    $language_names[$lan]=$value;
                };
            ?>

            <h4 class="m-0">Languages</h4>
            @foreach($language_names as $language=>$count)
                <?php
                    $totalLanguages = abs(($count * 100 / count($lanCodes)));
                ?>
                <div class="my-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="m-0">{{$language}}</p>
                        </div>
                        <div>
                            <span style="font-size: 13px">{{round($totalLanguages)}}%</span>
                            <span style="padding-left: 16px">{{$count}}</span>
                        </div>
                    </div>
                    <div class="progress" style="height: 8px">
                        <div class="progress-bar" role="progressbar" style="width: {{round($totalLanguages)}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            @endforeach
            @if ($link && $link->id)
                <a class="text-decoration-none" href="/dashboard/biolink/analytics/{{$link->id}}/languages">View More</a>
            @endif
        </div>
    </div>
</div>
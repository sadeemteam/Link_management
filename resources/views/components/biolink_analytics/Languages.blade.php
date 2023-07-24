<div class="card p-3">
    <?php
        // accesing the language codes and total value
        $lanCodes = array();
        foreach($analytics as $item){
            $lan = json_decode($item->languages);
            array_push($lanCodes, $lan[1]);
        };
        
        // calculating that how many lanCode;
        $languagesCounted=array_count_values($lanCodes);

        function getLanName ($languages, $code) {
            $lan_name='';
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
            $lan = getLanName($languages, $key);
            $language_names[$lan]=$value;
        };
    ?>

    <h4 class="m-0">{{__('Languages')}}</h4>
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
</div>
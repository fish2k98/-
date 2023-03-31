<?
    $url = "https://hentairead.com";
    $data = Getfile($url);

    function Getfile($url)
    {
        $lines = file ($url);
        $i = 0;
        foreach ($lines as $line_num => $line) 
        {
            if(strpos($line,"<a href=\"https://hentairead.com/hentai/") === 0 && strpos($line,"title"))
            {
                preg_match('/(?<=<a href=").*?(?=" title)/', $line, $link);
                $data[$i]['link'] = $link[0];
                preg_match('/(?<=title=").*?(?=">)/', $line, $name);
                $data[$i]['name'] = $name[0];
            }
            if(strpos($line,"Pages: "))
            {
                preg_match('/(?<=Pages: ).*?(?=<)/', $line, $pages);
                $data[$i]['pages'] = $pages[0];
                if((int)$data[$i]['pages'] < 20)
                {
                    $i++;
                }
            }
        }
        return $data;
    }
    
    function getimglink($url)
    {
        $lines = file ($url);
        foreach ($lines as $line_num => $line) 
        {
            if(strpos($line,"https://i0.wp.com/hentairead.com/wp-content/uploads/WP-manga/"))
            {
                preg_match('/(?<=data\/).*?(?=\/001)/', $line, $target);
                    return "https://i0.wp.com/hentairead.com/wp-content/uploads/WP-manga/data/".$target[0];
            }
        }
    }
	
    $rand = rand(0, count($data) - 1);
    $link = $data[$rand]['link'];
    $targeturl  = getimglink($data[$rand]['link']);
    $targetname  = $data[$rand]['name'];
    $targetpages  = $data[$rand]['pages'];
    $data = NULL;
    $data[0]['data']['name'] = "老子是色批bot!!!";
    $data[0]['type'] = 'node';
    $data[0]['data']['uin'] = "3457634573";
    $data[0]['data']['content'] = $targetname;
    
    $data[1]['data']['name'] = "老子是色批bot!!!";
    $data[1]['type'] = 'node';
    $data[1]['data']['uin'] = "3457634573";
    $data[1]['data']['content'] = "页数:".$targetpages;
    
    $data[2]['data']['name'] = "老子是色批bot!!!";
    $data[2]['type'] = 'node';
    $data[2]['data']['uin'] = "3457634573";
    $data[2]['data']['content'] = "链接：".$link;

    for($i = 1;$i<= $targetpages;$i++)
    {
        $data[$i+2]['data']['name'] = "老子是色批bot!!!";
        $data[$i+2]['type'] = 'node';
        $data[$i+2]['data']['uin'] = "3457634573";
        if($i< 10)
            $img = $targeturl."/00".$i.".jpeg";
        else
            $img = $targeturl."/0".$i.".jpeg";
        $data[$i+2]['data']['content'] = "预览：[CQ:image,file=$img]";
    }

    $data = json_encode($data);
    
    @NoifyToGroup($data);
    
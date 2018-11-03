<?php
include 'pharse/pharse.php';
class Sindyk
{
    protected $url;
    protected $html;
    protected $menu;
    protected $plans;
    protected $image;
    protected $meta;
    protected $logo;
    
    public function __construct($url)
    {
        $this->url = $url;
        $this->html = Pharse::file_get_dom($url);
    }

    private function cleanHTML($tags)
    {
        $tags = trim($tags);
        $tags = preg_replace('/\s+/', ' ', $tags);
        $tags = preg_replace('/(\r\n)+|\r+|\n+|\t+/i', ' ', $tags);
        $tags = preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i', '<$1$2>', $tags);
        return $tags;
    }

    private function getImage()
    {
        if (!$this->image)
        {
            $html = $this->html;
            preg_match('/\((.*?)\)/', $html('[data-mkd-parallax-speed]', 0)->style, $image);
            $this->image = $image[1];
        }
        return $this->image;
    }

    private function getMeta()
    {
        if (!$this->meta)
        {
            $html = $this->html;
            $meta = $html('[data-mkd-parallax-speed] .wpb_wrapper', 0);
            $this->meta = [
                'title' => $this->cleanHTML($meta->getChild(1)->getPlainText()),
                'description' => $this->cleanHTML($meta->getChild(2)->getPlainText())
            ];
        }
        return $this->meta;
    }
    
    private function getLogo()
    {
        if (!$this->logo)
        {
            $html = $this->html;
            $logo = $html('.mkd-logo-wrapper img');
            $this->logo = [
                'dark' => $logo[1]->src,
                'light' => $logo[2]->src
            ];
        }
        return $this->logo;
    }

    public function getInfo()
    {
        return [
            'image' => $this->getImage(),
            'title' => $this->getMeta()['title'],
            'description' => $this->getMeta()['description'],
            'logo_light' => $this->getLogo()['light'],
            'logo_dark' => $this->getLogo()['dark'],
            'url' => $this->url
        ];
    }

    public function getMenu()
    {
        if (!$this->menu)
        {
            $html = $this->html;
            $menu = [];

            $id = [
                'incremental' => 0,
                'item' => 0,
                'subitem' => 0
            ];
            
            foreach ($html('#menu-menu-header', 0)->getChildrenByTag('li', 'name', false) as $item) {
                $id['incremental']++;
                $id['item'] = $id['incremental'];
                $menu[] = [
                    'id' => $id['incremental'],
                    'url' => $item('a', 0)->href,
                    'label' => $item('a', 0)->getPlainText(),
                    'parent' => 0
                ];

                if (strpos($item->attributes['class'], 'has_sub')) {
                    $menu[$id['incremental']-1]['url'] = '#';
                    foreach ($item('ul', 0)->getChildrenByTag('li', 'name', false) as $subitem) {
                        $id['incremental']++;
                        $id['subitem'] = $id['incremental'];
                        $menu[] = [
                            'id' => $id['incremental'],
                            'url' => $subitem('a', 0)->href,
                            'label' => $subitem('a', 0)->getPlainText(),
                            'parent' => $id['item']
                        ];
                        if (strpos($subitem->attributes['class'], 'sub')) {
                            $menu[$id['incremental']-1]['url'] = '#';
                            foreach ($subitem('ul', 0)->getChildrenByTag('li', 'name', false) as $undersubitem) {
                                $id['incremental']++;
                                $menu[] = [
                                    'id' => $id['incremental'],
                                    'url' => $undersubitem('a', 0)->href,
                                    'label' => $undersubitem('a', 0)->getPlainText(),
                                    'parent' => $id['subitem']
                                ];
                            }
                        }
                    }
                }
            }
            $this->menu = $menu;
        }
        return $this->menu;
    }

    public function getPlans()
    {
        if (!$this->plans)
        {
            $html = $this->html;
            $plans = [];
            foreach ($html('.mkd-price-table') as $table) {
                $table('.mkd-currency', 0)->delete();
                array_push($plans, [
                    'title' => $table('.mkd-title-content', 0)->getPlainText(),
                    'period' => $table('.mkd-pt-price-period-content', 0)->getPlainText(),
                    'price' => $table('.mkd-price-currency', 0)->getPlainText(),
                    'description' => $this->cleanHTML($table('.mkd-table-content ul', 0)->html()),
                    'url' => $table('a', 0)->href,
                    'best' => $table('.mkd-active-label') ? 1 : 0,
                ]);
            }
            $this->plans = $plans;
        }
        return $this->plans;
    }

    public function getAll($raw = true)
    {
        $structure = [
            'menu' => $this->getMenu(),
            'information' => [
                'image' => $this->getImage(),
                'title' => $this->getMeta()['title'],
                'description' => $this->getMeta()['description'],
                'logo_light' => $this->getLogo()['light'],
                'logo_dark' => $this->getLogo()['dark'],
                'plans' => $this->getPlans()
            ]
        ];

        return $raw ? $structure : json_encode($structure, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}

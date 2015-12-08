<?php
function showFlash($x)
{
    $arr = array('success', 'error', 'warning', 'alert');
    $mess = null;
    foreach ($arr as $v):
        $mess = $x->session->flashdata($v);
        if (!empty($mess))
            break;
    endforeach;

    if (empty($mess))
        return;
    echo '<div class="row-fluid"><div class="alert alert-' . $v . ' span12">
	<a href="#" class="close" data-dismiss="alert">&times;</a><h4>' . ucfirst($v) . ':</h4> ' . htmlspecialchars($mess) . '</div></div>';
}

function getPhone($str = null, $deco = false)
{
    if (empty($str))
        return null;
    $p = '#(?P<phone>\d{8,11})\((?P<name>\w*)\)#imu';
    $isM = preg_match_all($p, $str, $m, PREG_SET_ORDER);

    if ($isM)
        foreach ($m as $v):
            if ($deco)
                echo html_escape($v['phone']) . ' <span class="phone"> --> ' . html_escape($v['name']) . '</span> ';
            else
                echo '<span class="phone_block">' . html_escape($v['phone']) .
                    '<span class="footer_highlight">(' . html_escape($v['name']) .
                    ')</span></span>';
        endforeach;
}

function parseBbcode($str)
{
    $str = nl2br($str);
    $find = array(
        "'\[img\](.*?)\[/img\]'i",
        "'\[url\](.*?)\[/url\]'i",
        "'\[url=(.*?)\](.*?)\[/url\]'i",
        "'\[email=(.*?)\](.*?)\[/email\]'i",
        "'\[youtube\](.*?)\[/youtube\]'i",

        "'\[ul\](.*?)\[/ul\]'is", "'\[li\](.*?)\[/li\]'is", "'\[ol\](.*?)\[/ol\]'is",

        "'\[table\](.*?)\[/table\]'is",
        "'\[tr\](.*?)\[/tr\]'is",
        "'\[td\](.*?)\[/td\]'is",

        "'\[hr\]'i",
    );

    $replace = array(
        '<img src="\1" alt="" />',
        '<a href="\1">\1</a>',
        '<a href="\1">\2</a>',
        '<a href="mailto:\1">\2</a>',
        '<iframe width="420" height="315" src="http://www.youtube.com/embed/\1" frameborder="0" allowfullscreen></iframe>',

        '<ul>\1</ul>', '<li>\1</li>', '<ol>\1</ol>',

        '<table>\1</table>',
        '<tr>\1</tr>', '<td>\1</td>',

        '<hr />'
    );

    $att = array(
        'strong' => 'b', 'em' => 'i', 'u' => 'u', 's' => 's',
        'sub' => 'sub', 'sup' => 'sup',
        'p class="text-left"' => 'left', 'p class="text-right"' => 'right',
        'p class="text-center"' => 'center', 'p' => 'justify',
        'p dir="ltr"' => 'ltr', 'p dir="rtf"' => 'rtl',
        array(
            'open' => 'size=(\d+)', 'openR' => 'font size="\1"',
            'close' => 'size', 'closeR' => 'font'
        ),
        array(
            'open' => 'color=\#(\w{3,6})',
            'openR' => 'span style="color:#$1"',
            'close' => 'color',
            'closeR' => 'span'
        ),
        array(
            'open' => 'color=(\w+)',
            'openR' => 'span style="color:$1"',
            'close' => 'color',
            'closeR' => 'span'
        ),
        array(
            'open' => 'font=(.*?)', 'openR' => 'span style="font-family:\1"',
            'close' => 'font', 'closeR' => 'span'
        )
    );

    foreach ($att as $k => $v):
        if (is_array($v)):
            $open = $v['open'];
            $openR = $v['openR'];
            $close = $v['close'];
            $closeR = $v['closeR'];
        else:
            $open = $close = $v;
            $openR = $closeR = $k;
        endif;
        $str = preg_replace(
            "#\[" . $open . "\]#is",
            "<" . $openR . ">", $str
        );
        $str = preg_replace(
            "#\[\/" . $close . "\]#i",
            "</" . $closeR . ">", $str
        );
    endforeach;
    //$str = preg_replace($find, $replace, $str);
    return preg_replace($find, $replace, $str);
}

function orderStatus($status, $x, $show = true)
{
    switch ($status):
        case 1 :
            $mess = '<label class="label label-success">' . $x[$status] . '</label>';
            break;
        case 2 :
        case 4:
            $mess = '<label class="label label-warning">' . $x[$status] . '</label>';
            break;
        case 8 :
        case 0 :
            $mess = '<label class="label label-important">' . $x[$status] . '</label>';
            break;
        default:
            $mess = '<label class="label label-error">Không tìm thấy biến</label>';
    endswitch;

    if ($show)
        echo $mess;
    else
        return $mess;
}

function recursive($category)
{
    foreach ($category as $k => $v):
        ?>
    <li id="list_<?php echo $v['id']; ?>">
        <div><span class="disclose"><span></span></span><?php
            echo html_escape($v['name']);
            ?></div>
        <div class="label"><?php
            echo anchor('/admincp/category/edit/' . $v['id'], 'Edit') . '&nbsp;' .
                anchor('/admincp/category/delete/' . $v['id'], 'Delete');
            ?></div>
        <?php
        if (!empty($v['child'])):
            echo '<ol>';
            echo recursive($v['child']);
            echo '</ol>';
        endif;
        ?></li><?php
    endforeach;
}

function countPrice($x)
{
    $n = strtotime(date('Y-m-d'));
    $start = strtotime($x->start);
    $start = ($start) ? $start : 0;

    if (strtotime($x->start) <= $n && strtotime($x->end) >= $n)
        $x->price = $x->price - ($x->price * $x->sale) / 100;

    return number_format($x->price, 3, '.', ' ') . ' VNĐ';
}

class common_helper
{
    protected $x;
    public $link;

    public function __construct($x = null, $url = null)
    {
        $this->x = $x;
        $this->link = $url;
    }

    public function sortRow($id = null, $name = null, $create_link = true)
    {
        if (empty($id)) return false;
        if ($this->x->data['pagination_sortBy'] == $id):
            $link = ($this->x->data['pagination_sortOrder'] == 'asc') ? 'desc' : 'asc';
            $sortOrder = $this->x->data['pagination_sortOrder'];
            $sortBy = $this->x->data['pagination_sortBy'];
        else:
            $sortOrder = null;
            $link = 'desc';
            $sortBy = $id;
        endif;

        if ($create_link):
            echo anchor(
                    base_url($this->link . '/' . $sortBy . '/' . $link),
                    $name, 'class="sortRow ' . $sortOrder . '"'
                ) . ' ';
        else:
            return 'sortRow ' . $sortOrder;
        endif;
    }

    public function category_drop($category, $depth = false)
    {
        $drop = array();
        if (!$depth)
            $drop[0] = ' ';

        if (!empty($category))
            foreach ($category as $k => $v):
                if (!isset($v['child']) && $depth):
                    $drop[$v['id']] = $v['name'];
                else:
                    if ($depth):
                        $drop[$v['name']] = array();
                        if (empty($v['child'])) {
                            $drop[$v['name']][] = '';
                            continue;
                        }
                        foreach ($v['child'] as $childV)
                            $drop[$v['name']][$childV['id']] = $childV['name'];

                    else:
                        $drop[$v['id']] = $v['name'];
                    endif;
                endif;
            endforeach;

        return $drop;
    }
}
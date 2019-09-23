<script type="text/javascript">

var TimeOut         = 300;
var currentLayer    = null;
var currentitem     = null;

var currentLayerNum = 0;
var noClose         = 0;
var closeTimer      = null;

// Open Hidden Layer
function mopen(n)
{
    var l  = document.getElementById("menu"+n);
    var mm = document.getElementById("mmenu"+n);

    if(l)
    {
        mcancelclosetime();
        l.style.visibility='visible';

        if(currentLayer && (currentLayerNum != n))
            currentLayer.style.visibility='hidden';

        currentLayer = l;
        currentitem = mm;
        currentLayerNum = n;
    }
    else if(currentLayer)
    {
        currentLayer.style.visibility='hidden';
        currentLayerNum = 0;
        currentitem = null;
        currentLayer = null;
	}
}

// Turn On Close Timer
function mclosetime()
{
    closeTimer = window.setTimeout(mclose, TimeOut);
}

// Cancel Close Timer
function mcancelclosetime()
{
    if(closeTimer)
    {
        window.clearTimeout(closeTimer);
        closeTimer = null;
    }
}

// Close Showed Layer
function mclose()
{
    if(currentLayer && noClose!=1)
    {
        currentLayer.style.visibility='hidden';
        currentLayerNum = 0;
        currentLayer = null;
        currentitem = null;
    }
    else
    {
        noClose = 0;
    }

    currentLayer = null;
    currentitem = null;
}

// Close Layer Then Click-out
document.onclick = mclose;
</script>
<style>
.submenu
{
	color:#000;
	background: #fff;
    border: 1px solid #ddd;
    visibility: hidden;
    position: absolute;
    z-index: 3;
	margin: 0px;
	text-align:center;
	font-size:11px;
}

.submenu a
{   display: block;
	text-decoration: none;
	margin: 0px;
	padding: 8px 8px;
	color: #000;
	text-align:center;
	border-bottom:solid 1px #ddd;
}

.submenu a:hover
{
	background: #ffc78e;
	color: #000000;
}
.submenu span {
	text-decoration: none;
	padding: 4px 5px;
	background: #ddd;
}
.submenu .tel {
	color:#339900;
}
</style>


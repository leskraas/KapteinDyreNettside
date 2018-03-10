<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style type="text/css">
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    body {
    height: 100vh;
    }

    .flex {
    display: flex;
    width: 100%;
    }

    .middle { margin: auto; }

    #swipeMenu {
    background: silver;
    overflow: hidden;
    width: 100%;
    -webkit-backface-visibility: hidden;
    -webkit-transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
    -webkit-transform-style: preserve-3d;
    }

    #swipeMenu ul.animate { transition: all .3s; }

    #swipeMenu ul {
    -webkit-transform: translate3d(0%, 0, 0) scale3d(1, 1, 1);
    -moz-transform: translate3d(0%, 0, 0) scale3d(1, 1, 1);
    -ms-transform: translate3d(0%, 0, 0) scale3d(1, 1, 1);
    -o-transform: translate3d(0%, 0, 0) scale3d(1, 1, 1);
    transform: translate3d(0%, 0, 0) scale3d(1, 1, 1);
    overflow: hidden;
    -webkit-backface-visibility: hidden;
    -webkit-transform-style: preserve-3d;
    }

    #swipeMenu ul {
    height: 100vh;
    -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    position: relative;
    }

    #swipeMenu li {
    display: flex;
    float: left;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    -webkit-transform-style: preserve-3d;
    -webkit-transform: translate3d(0, 0, 0);
    }

    #swipeMenu li.menu {
    max-width: 15%;
    background-color: #2C3E50;
    }

    #swipeMenu li.menu nav {
    float: left;
    width: 100%;
    padding: 0 15px;
    }

    #swipeMenu li.menu nav a {
    float: left;
    width: 100%;
    padding: 10px 20px;
    border-bottom: 1px dotted #fff;
    color: #fff;
    text-decoration: none;
    position: relative;
    }

    #swipeMenu li.menu nav a:before {
    content: '';
    width: 6px;
    height: 6px;
    border: 1px solid #fff;
    border-radius: 100%;
    position: absolute;
    top: 16px;
    left: 8px;
    }

    #swipeMenu li.page {
    width: 100%;
    background-color: #34495E;
    position: relative;
    box-shadow: 5px 0px 36px 7px rgba(0, 0, 0, 0.2);
    }

    a.menu-icon {
    width: 34px;
    height: 28px;
    position: absolute;
    top: 20px;
    left: 20px;
    }

    a.menu-icon span {
    width: 100%;
    height: 4px;
    margin: -2px 0 0 0;
    background-color: #fff;
    position: absolute;
    top: 50%;
    left: 0;
    }

    a.menu-icon span:before, a.menu-icon span:after {
    content: '';
    width: 100%;
    height: 4px;
    background-color: #fff;
    position: absolute;
    left: 0;
    }

    a.menu-icon span:before { top: -12px; }

    a.menu-icon span:after { bottom: -12px; }
    </style>

    <script src="jquery.min.js"></script>
    2
    <script src="modernizr.min.js"></script>
    3
    <script src="hhammer.min.js"></script>
    <script>
    function swipeMenu(element) {
    var self = this;
    element = $(element);
    var container = $('>ul', element);
    var panes = $('>ul>li', element);
    var pane_width = 0;
    var pane_count = panes.length;
    var current_pane = 0;
    this.init = function () {
    setPaneDimensions();
    $(window).on('load resize orientationchange', function () {
    setPaneDimensions();
    });
    };
    function setPaneDimensions() {
    pane_width = element.width();
    panes.each(function () {
    $(this).width(pane_width);
    });
    container.width(pane_width * pane_count);
    }
    ;
    this.showPane = function (index, animate) {
    index = Math.max(0, Math.min(index, pane_count - 1));
    current_pane = index;
    var offset = -(30 / pane_count * current_pane);
    setContainerOffset(offset, animate);
    };
    function setContainerOffset(percent, animate) {
    container.removeClass('animate');
    if (animate) {
    container.addClass('animate');
    }
    if (Modernizr.csstransforms3d) {
    container.css('transform', 'translate3d(' + percent + '%,0,0) scale3d(1,1,1)');
    } else if (Modernizr.csstransforms) {
    container.css('transform', 'translate(' + percent + '%,0)');
    } else {
    var px = pane_width * pane_count / 30 * percent;
    container.css('left', px + 'px');
    }
    }
    this.next = function () {
    return this.showPane(current_pane + 1, true);
    };
    this.prev = function () {
    return this.showPane(current_pane - 1, true);
    };
    function handleHammer(ev) {
    ev.gesture.preventDefault();
    switch (ev.type) {
    case 'dragright':
    case 'dragleft':
    var pane_offset = -(30 / pane_count) * current_pane;
    var drag_offset = 30 / pane_width * ev.gesture.deltaX / pane_count;
    if (current_pane == 0 && ev.gesture.direction == 'right' || current_pane == pane_count - 1 && ev.gesture.direction == 'left') {
    drag_offset *= 0.4;
    }
    setContainerOffset(drag_offset + pane_offset);
    break;
    case 'swipeleft':
    self.next();
    ev.gesture.stopDetect();
    break;
    case 'swiperight':
    self.prev();
    ev.gesture.stopDetect();
    break;
    case 'release':
    if (Math.abs(ev.gesture.deltaX) > pane_width / 2) {
    if (ev.gesture.direction == 'right') {
    self.prev();
    } else {
    self.next();
    }
    } else {
    self.showPane(current_pane, true);
    }
    break;
    }
    }
    new Hammer(element[0], { drag_lock_to_axis: true }).on('release dragleft dragright swipeleft swiperight', handleHammer);
    }

    var swipeMenu = new swipeMenu('#swipeMenu');
    swipeMenu.init();
    swipeMenu.showPane(1, false);
    $(document).ready(function () {
    $('#swipeMenu ul').attr('style', 'transform: translate3d(-15%, 0px, 0px) scale3d(1, 1, 1);');
    $('a.menu-icon').click(function () {
    $(this).toggleClass('active');
    swipeMenu.showPane(0, true);
    return false;
    });
    });
    </script>

</head>
<body>

<div id="swipe"><a href="http://www.jqueryscript.net/menu/">Menu</a>">
<ul>
    <li class="menu">
        <nav>
            <a href="">Menu Item 1</a>
            <a href="">Menu Item 2</a>
            <a href="">Menu Item 3</a>
            <a href="">Menu Item 4</a>
            <a href="">Menu Item 5</a>
        </nav>
    </li>
    <li class="page">
        <a href="#" class="menu-icon"><span></span></a>
        <div class="flex">
            <div class="middle"><h1>Swipe to open menu</h1></div>
        </div>
    </li>
</ul>
</div>



</body>
</html>
/**
 * Javascript Functions
 *
 * @category  public
 * @package   js
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/
// function to check for an empty object
function isEmptyObj(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}
function isEmpty(str){
    if( (null == str) || (str == "") ) {
        return true;
    }else{
        return false;
    }
}
function printr_json(obj)
{
    //json형태의 데이터를 트리구조로 출력해준다.
    //사용예 : alert(printr_json(obj))
    return 	JSON.stringify( obj, null, 11 );
}
function is_undefined(obj)
{
    var result = false;
    if(typeof obj == 'undefined')	result = true;
    return result;
}

function getUrlField(url)
{
    //URL을 파싱하여 field값을 얻는다.
    //예시1)domain.com/field?param1=value1&param2=value2.... 라는 주소에서
    //field를 리턴한다.
    //예시2)domain.com/field
    //field를 리턴한다.
    var hashes = [];
    if(url == null) url = window.location.href;
    if( url.indexOf('?') > 0 )
    {
        var hashes = url.slice(0,url.indexOf('?')).split('/');
    }
    else
    {
        var hashes = url.split('/');
    }
    return hashes[hashes.length-1];
}

function QueryString (query) {
    // This function is anonymous, is executed immediately and
    // the return value is assigned to QueryString!
    var query_string = {};
    if(isEmpty(query)){
        query = window.location.search.substring(1);
    }
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        // If first entry with this name
        if (typeof query_string[pair[0]] === "undefined") {
            query_string[pair[0]] = pair[1];
            // If second entry with this name
        } else if (typeof query_string[pair[0]] === "string") {
            var arr = [ query_string[pair[0]], pair[1] ];
            query_string[pair[0]] = arr;
            // If third or later entry with this name
        } else {
            query_string[pair[0]].push(pair[1]);
        }
    }
    return query_string;
};
//상단으로 canvas 올리기
var scrollY = function (y) {
    if (window.jQuery) {
        FB.Canvas.getPageInfo (function (pageInfo) {
            $({ y: pageInfo.scrollTop })
                .animate({
                    y: y
                },
                {
                    duration: 1000,
                    step: function (offset) {
                        FB.Canvas.scrollTo(0, offset);
                    }
                });
        });
    } else {
        FB.Canvas.scrollTo(0, y);
    }
};
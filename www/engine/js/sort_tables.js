/*
originally written by paul sowden <paul@idontsmoke.co.uk> | http://idontsmoke.co.uk
modified and localized by alexander shurkayev <alshur@narod.ru> | http://htmlcoder.visions.ru
*/

var img_dir = "i/"; // папка с картинками
var sort_case_sensitive = false; // вид сортировки (регистрозависимый или нет)

// ф-ция, определяющая алгоритм сортировки
function _sort(a, b) {
    var a = a[0];
    var b = b[0];
    if (Number(a) && Number(b)) return sort_numbers(a, b);
    else if (!sort_case_sensitive) return sort_insensitive(a, b);
    else return sort_sensitive(a, b);
}

// ф-ция сортировки чисел
function sort_numbers(a, b) {
    return a - b;
}

// ф-ция регистронезависимой сортировки
function sort_insensitive(a, b) {
    var anew = a.toLowerCase();
    var bnew = b.toLowerCase();
    if (anew < bnew) return -1;
    if (anew > bnew) return 1;
    return 0;
}

// ф-ция регистрозависимой сортировки
function sort_sensitive(a, b) {
    if (a < b) return -1;
    if (a > b) return 1;
    return 0;
}

// вспомогательная ф-ция, выдирающая из дочерних узлов весь текст
function getConcatenedTextContent(node) {
    var _result = "";
    if (node == null) {
        return _result;
    }
    var childrens = node.childNodes;
    var i = 0;
    while (i < childrens.length) {
        var child = childrens.item(i);
        switch (child.nodeType) {
            case 1: // ELEMENT_NODE
            case 5: // ENTITY_REFERENCE_NODE
                _result += getConcatenedTextContent(child);
                break;
            case 3: // TEXT_NODE
            case 2: // ATTRIBUTE_NODE
            case 4: // CDATA_SECTION_NODE
                _result += child.nodeValue;
                break;
            case 6: // ENTITY_NODE
            case 7: // PROCESSING_INSTRUCTION_NODE
            case 8: // COMMENT_NODE
            case 9: // DOCUMENT_NODE
            case 10: // DOCUMENT_TYPE_NODE
            case 11: // DOCUMENT_FRAGMENT_NODE
            case 12: // NOTATION_NODE
            // skip
            break;
        }
        i++;
    }
    return _result;
}

// суть скрипта
function sort(el) {
    var a = new Array();
    var name = el.lastChild.nodeValue;
    var dad = el.parentNode;
    var table = dad.parentNode.parentNode;
    var up = table.up;
    var node, arrow, curcol;
    for (var i = 0; node = dad.childNodes[i]; i++) {
        if (node.lastChild.nodeValue == name){
            curcol = i;
            if (node.className == "curcol"){
                arrow = node.firstChild;
                table.up = Number(!up);
                arrow.src = img_dir + table.up + ".gif";
                arrow.alt = "";
            }else{
                node.className = "curcol";
                arrow = node.insertBefore(document.createElement("img"),node.firstChild);
                table.up = 0;
                arrow.src = img_dir + Number(table.up) + ".gif";
                arrow.alt = "";
            }
        }else{
            if (node.className == "curcol"){
                node.className = "";
                if (node.firstChild) node.removeChild(node.firstChild);
            }
        }
    }
    var tbody = table.getElementsByTagName("tbody").item(0);
    for (var i = 0; (node = tbody.childNodes[i]); i++) {
        a[i] = new Array();
        a[i][0] = getConcatenedTextContent(node.childNodes.item(curcol));
        a[i][1] = getConcatenedTextContent(node.childNodes.item(1));
        a[i][2] = getConcatenedTextContent(node.childNodes.item(0));
        a[i][3] = node;
    }
    a.sort(_sort);
    if (table.up) a.reverse();
    for (var i = 0; i < a.length; i++) {
        tbody.appendChild(a[i][3]);
    }
}
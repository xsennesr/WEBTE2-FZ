import './bootstrap';
import { Collapse } from "flowbite";

$("#task").keyup(function () {
    $("#task-tex").html($(this).val());
    var math = document.getElementById("task-tex");
    MathJax.Hub.Queue(["Typeset", MathJax.Hub, math]);
    //MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
});

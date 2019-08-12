define("partials/help", ["require", "exports"], function (require, exports) {
    "use strict";
    exports.__esModule = true;
    function al() {
        alert('someThinf');
    }
    exports.al = al;
});
define("app", ["require", "exports", "partials/help"], function (require, exports, help_1) {
    "use strict";
    exports.__esModule = true;
    help_1.al();
    help_1.al();
    alert('asdasd');
});
//# sourceMappingURL=app.js.map
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime/helpers/createClass"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _createSuper2 = _interopRequireDefault(require("@babel/runtime/helpers/createSuper"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _mjmlCore = require("mjml-core");

let MjBreakpoint = /*#__PURE__*/function (_HeadComponent) {
  (0, _inherits2.default)(MjBreakpoint, _HeadComponent);

  var _super = (0, _createSuper2.default)(MjBreakpoint);

  function MjBreakpoint() {
    (0, _classCallCheck2.default)(this, MjBreakpoint);
    return _super.apply(this, arguments);
  }

  (0, _createClass2.default)(MjBreakpoint, [{
    key: "handler",
    value: function handler() {
      const {
        add
      } = this.context;
      add('breakpoint', this.getAttribute('width'));
    }
  }]);
  return MjBreakpoint;
}(_mjmlCore.HeadComponent);

exports.default = MjBreakpoint;
(0, _defineProperty2.default)(MjBreakpoint, "componentName", 'mj-breakpoint');
(0, _defineProperty2.default)(MjBreakpoint, "endingTag", true);
(0, _defineProperty2.default)(MjBreakpoint, "allowedAttributes", {
  width: 'unit(px)'
});
module.exports = exports.default;
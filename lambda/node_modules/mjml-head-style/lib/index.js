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

let MjStyle = /*#__PURE__*/function (_HeadComponent) {
  (0, _inherits2.default)(MjStyle, _HeadComponent);

  var _super = (0, _createSuper2.default)(MjStyle);

  function MjStyle() {
    (0, _classCallCheck2.default)(this, MjStyle);
    return _super.apply(this, arguments);
  }

  (0, _createClass2.default)(MjStyle, [{
    key: "handler",
    value: function handler() {
      const {
        add
      } = this.context;
      add(this.getAttribute('inline') === 'inline' ? 'inlineStyle' : 'style', this.getContent());
    }
  }]);
  return MjStyle;
}(_mjmlCore.HeadComponent);

exports.default = MjStyle;
(0, _defineProperty2.default)(MjStyle, "componentName", 'mj-style');
(0, _defineProperty2.default)(MjStyle, "endingTag", true);
(0, _defineProperty2.default)(MjStyle, "allowedAttributes", {
  inline: 'string'
});
module.exports = exports.default;
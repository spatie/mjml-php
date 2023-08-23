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

let MjFont = /*#__PURE__*/function (_HeadComponent) {
  (0, _inherits2.default)(MjFont, _HeadComponent);

  var _super = (0, _createSuper2.default)(MjFont);

  function MjFont() {
    (0, _classCallCheck2.default)(this, MjFont);
    return _super.apply(this, arguments);
  }

  (0, _createClass2.default)(MjFont, [{
    key: "handler",
    value: function handler() {
      const {
        add
      } = this.context;
      add('fonts', this.getAttribute('name'), this.getAttribute('href'));
    }
  }]);
  return MjFont;
}(_mjmlCore.HeadComponent);

exports.default = MjFont;
(0, _defineProperty2.default)(MjFont, "componentName", 'mj-font');
(0, _defineProperty2.default)(MjFont, "allowedAttributes", {
  name: 'string',
  href: 'string'
});
module.exports = exports.default;
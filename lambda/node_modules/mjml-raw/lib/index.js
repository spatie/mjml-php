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

let MjRaw = /*#__PURE__*/function (_BodyComponent) {
  (0, _inherits2.default)(MjRaw, _BodyComponent);

  var _super = (0, _createSuper2.default)(MjRaw);

  function MjRaw() {
    (0, _classCallCheck2.default)(this, MjRaw);
    return _super.apply(this, arguments);
  }

  (0, _createClass2.default)(MjRaw, [{
    key: "render",
    value: function render() {
      return this.getContent();
    }
  }]);
  return MjRaw;
}(_mjmlCore.BodyComponent);

exports.default = MjRaw;
(0, _defineProperty2.default)(MjRaw, "componentName", 'mj-raw');
(0, _defineProperty2.default)(MjRaw, "endingTag", true);
(0, _defineProperty2.default)(MjRaw, "rawElement", true);
(0, _defineProperty2.default)(MjRaw, "allowedAttributes", {
  position: 'enum(file-start)'
});
module.exports = exports.default;
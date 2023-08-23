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

let MjHead = /*#__PURE__*/function (_HeadComponent) {
  (0, _inherits2.default)(MjHead, _HeadComponent);

  var _super = (0, _createSuper2.default)(MjHead);

  function MjHead() {
    (0, _classCallCheck2.default)(this, MjHead);
    return _super.apply(this, arguments);
  }

  (0, _createClass2.default)(MjHead, [{
    key: "handler",
    value: function handler() {
      return this.handlerChildren();
    }
  }]);
  return MjHead;
}(_mjmlCore.HeadComponent);

exports.default = MjHead;
(0, _defineProperty2.default)(MjHead, "componentName", 'mj-head');
module.exports = exports.default;
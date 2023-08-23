"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = exports.matcher = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _createSuper2 = _interopRequireDefault(require("@babel/runtime/helpers/createSuper"));

var _type = _interopRequireDefault(require("./type"));

const matcher = /^string/gim;
exports.matcher = matcher;

var _default = () => /*#__PURE__*/function (_Type) {
  (0, _inherits2.default)(NString, _Type);

  var _super = (0, _createSuper2.default)(NString);

  function NString(value) {
    var _this;

    (0, _classCallCheck2.default)(this, NString);
    _this = _super.call(this, value);
    _this.matchers = [/.*/];
    return _this;
  }

  return NString;
}(_type.default);

exports.default = _default;
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = exports.matcher = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _createSuper2 = _interopRequireDefault(require("@babel/runtime/helpers/createSuper"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _escapeRegExp2 = _interopRequireDefault(require("lodash/escapeRegExp"));

var _type = _interopRequireDefault(require("./type"));

const matcher = /^enum/gim;
exports.matcher = matcher;

var _default = params => {
  var _class, _temp;

  const matchers = params.match(/\(([^)]+)\)/)[1].split(',');
  return _temp = _class = /*#__PURE__*/function (_Type) {
    (0, _inherits2.default)(Enum, _Type);

    var _super = (0, _createSuper2.default)(Enum);

    function Enum(value) {
      var _this;

      (0, _classCallCheck2.default)(this, Enum);
      _this = _super.call(this, value);
      _this.matchers = matchers.map(m => new RegExp(`^${(0, _escapeRegExp2.default)(m)}$`));
      return _this;
    }

    return Enum;
  }(_type.default), (0, _defineProperty2.default)(_class, "errorMessage", `has invalid value: $value for type Enum, only accepts ${matchers.join(', ')}`), _temp;
};

exports.default = _default;
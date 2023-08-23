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

let MjSpacer = /*#__PURE__*/function (_BodyComponent) {
  (0, _inherits2.default)(MjSpacer, _BodyComponent);

  var _super = (0, _createSuper2.default)(MjSpacer);

  function MjSpacer() {
    (0, _classCallCheck2.default)(this, MjSpacer);
    return _super.apply(this, arguments);
  }

  (0, _createClass2.default)(MjSpacer, [{
    key: "getStyles",
    value: function getStyles() {
      return {
        div: {
          height: this.getAttribute('height'),
          'line-height': this.getAttribute('height')
        }
      };
    }
  }, {
    key: "render",
    value: function render() {
      return `
      <div
        ${this.htmlAttributes({
        style: 'div'
      })}
      >&#8202;</div>
    `;
    }
  }]);
  return MjSpacer;
}(_mjmlCore.BodyComponent);

exports.default = MjSpacer;
(0, _defineProperty2.default)(MjSpacer, "componentName", 'mj-spacer');
(0, _defineProperty2.default)(MjSpacer, "allowedAttributes", {
  border: 'string',
  'border-bottom': 'string',
  'border-left': 'string',
  'border-right': 'string',
  'border-top': 'string',
  'container-background-color': 'color',
  'padding-bottom': 'unit(px,%)',
  'padding-left': 'unit(px,%)',
  'padding-right': 'unit(px,%)',
  'padding-top': 'unit(px,%)',
  padding: 'unit(px,%){1,4}',
  height: 'unit(px,%)'
});
(0, _defineProperty2.default)(MjSpacer, "defaultAttributes", {
  height: '20px'
});
module.exports = exports.default;
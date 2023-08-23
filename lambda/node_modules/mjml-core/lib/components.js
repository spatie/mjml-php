"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.assignComponents = assignComponents;
exports.registerComponent = registerComponent;
exports.default = void 0;

var _kebabCase2 = _interopRequireDefault(require("lodash/kebabCase"));

const components = {};

function assignComponents(target, source) {
  for (const component of source) {
    target[component.componentName || (0, _kebabCase2.default)(component.name)] = component;
  }
}

function registerComponent(Component) {
  assignComponents(components, [Component]);
}

var _default = components;
exports.default = _default;
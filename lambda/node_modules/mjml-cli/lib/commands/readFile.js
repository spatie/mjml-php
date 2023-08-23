"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = exports.flatMapPaths = void 0;

var _flatMap2 = _interopRequireDefault(require("lodash/flatMap"));

var _fs = _interopRequireDefault(require("fs"));

var _glob = _interopRequireDefault(require("glob"));

const flatMapPaths = paths => (0, _flatMap2.default)(paths, p => _glob.default.sync(p, {
  nodir: true
}));

exports.flatMapPaths = flatMapPaths;

var _default = path => {
  try {
    return {
      file: path,
      mjml: _fs.default.readFileSync(path).toString()
    };
  } catch (e) {
    // eslint-disable-next-line
    console.warn(`Cannot read file: ${path} doesn't exist or no access`, e);
    return {};
  }
};

exports.default = _default;
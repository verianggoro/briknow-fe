/*!
 * Author : Matteo Bruni - https://www.matteobruni.it
 * MIT license: https://opensource.org/licenses/MIT
 * Demo / Generator : https://particles.js.org/
 * GitHub : https://www.github.com/matteobruni/tsparticles
 * How to use? : Check the GitHub README
 * v1.14.2
 */
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("tsparticles"));
	else if(typeof define === 'function' && define.amd)
		define(["tsparticles"], factory);
	else {
		var a = typeof exports === 'object' ? factory(require("tsparticles")) : factory(root["window"]);
		for(var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
	}
})(this, function(__WEBPACK_EXTERNAL_MODULE__920__) {
return /******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ 920:
/***/ ((module) => {

module.exports = __WEBPACK_EXTERNAL_MODULE__920__;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: external {"commonjs":"tsparticles","commonjs2":"tsparticles","amd":"tsparticles","root":"window"}
var external_commonjs_tsparticles_commonjs2_tsparticles_amd_tsparticles_root_window_ = __webpack_require__(920);
;// CONCATENATED MODULE: ./dist/ConfettiDrawer.js

const ovalScalar = 0.6;
const types = ["square", "circle"];
class ConfettiDrawer {
  getSidesCount(particle) {
    const confetti = particle;
    return confetti.confettiType === "square" ? 4 : 12;
  }

  particleInit(container, particle) {
    var _a;

    const confetti = particle;
    const shapeData = (_a = confetti.shapeData) !== null && _a !== void 0 ? _a : {};

    if (shapeData.type === undefined) {
      shapeData.type = external_commonjs_tsparticles_commonjs2_tsparticles_amd_tsparticles_root_window_.Utils.itemFromArray(types);
    } else if (shapeData.type instanceof Array) {
      shapeData.type = external_commonjs_tsparticles_commonjs2_tsparticles_amd_tsparticles_root_window_.Utils.itemFromArray(shapeData.type);
    }

    confetti.confettiType = shapeData.type;
    confetti.wobble = external_commonjs_tsparticles_commonjs2_tsparticles_amd_tsparticles_root_window_.Vector.create(0, 0);
    confetti.wobble.length = particle.size.value * 2;
    confetti.wobble.angle = Math.random() * 10;
    confetti.wobbleInc = confetti.wobble.angle;
    confetti.wobbleSpeed = Math.min(0.11, Math.random() * 0.1 + 0.05) * container.retina.pixelRatio;
    confetti.tilt = external_commonjs_tsparticles_commonjs2_tsparticles_amd_tsparticles_root_window_.Vector.create(0, 0);
    confetti.tilt.length = 1;
    confetti.tilt.angle = (Math.random() * (0.75 - 0.25) + 0.25) * Math.PI;
    confetti.tiltSpeed = Math.min(0.11, Math.random() * 0.1 + 0.05) * container.retina.pixelRatio;
  }

  draw(context, particle, radius, opacity, delta) {
    const confetti = particle;
    confetti.wobble.angle += confetti.wobbleSpeed * delta.factor;
    confetti.wobbleInc += confetti.wobbleSpeed * delta.factor;
    confetti.tilt.angle += confetti.tiltSpeed * delta.factor;
    const random = Math.random() + 2;
    const x1 = random * confetti.tilt.x,
          y1 = random * confetti.tilt.y,
          x2 = confetti.wobble.x + random * confetti.tilt.x,
          y2 = confetti.wobble.y + random * confetti.tilt.y;

    if (confetti.confettiType === "circle") {
      context.ellipse(0, 0, Math.abs(x2 - x1) * ovalScalar, Math.abs(y2 - y1) * ovalScalar, Math.PI / 10 * confetti.wobbleInc, 0, 2 * Math.PI);
    } else {
      context.moveTo(0, 0);
      context.lineTo(confetti.wobble.x, y1);
      context.lineTo(x2, y2);
      context.lineTo(x1, confetti.wobble.y);
    }
  }

}
;// CONCATENATED MODULE: ./dist/shape.js

function loadConfettiShape(tsParticles) {
  tsParticles.addShape("confetti", new ConfettiDrawer());
}
;// CONCATENATED MODULE: ./dist/index.js


loadConfettiShape(external_commonjs_tsparticles_commonjs2_tsparticles_amd_tsparticles_root_window_.tsParticles);
})();

/******/ 	return __webpack_exports__;
/******/ })()
;
});
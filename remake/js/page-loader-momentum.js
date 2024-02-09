class Calc {

	/*
	------------------------------------------
	| rand:float - returns random float
	|
	| min:number - minimum value
	| max:number - maximum value
	| ease:function - easing function to apply to the random value
	|
	| Get a random float between two values,
	| with the option of easing bias.
	------------------------------------------ */
	rand(min, max, ease) {
		if(max === undefined) {
			max = min;
			min = 0;
		}
		let random = Math.random();
		if(ease) {
			random = ease(Math.random(), 0, 1, 1);
		}
		return random * (max - min) + min;
	}

	/*
	------------------------------------------
	| randInt:integer - returns random integer
	|
	| min:number - minimum value
	| max:number - maximum value
	| ease:function - easing function to apply to the random value
	|
	| Get a random integer between two values,
	| with the option of easing bias.
	------------------------------------------ */
	randInt(min, max, ease) {
		if(max === undefined) {
			max = min;
			min = 0;
		}
		let random = Math.random();
		if(ease) {
			random = ease(Math.random(), 0, 1, 1);
		}
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	/*
	------------------------------------------
	| randArr:item - returns random iem from array
	|
	| arr:array - the array to randomly pull from
	|
	| Get a random item from an array.
	------------------------------------------ */
	randArr(arr) {
		return arr[Math.floor(Math.random() * arr.length)];
	}

	/*
	------------------------------------------
	| map:number - returns a mapped value
	|
	| val:number - input value
	| inputMin:number - minimum of input range
	| inputMax:number - maximum of input range
	| outputMin:number - minimum of output range
	| outputMax:number - maximum of output range
	|
	| Get a mapped value from and input min/max
	| to an output min/max.
	------------------------------------------ */
	map(val, inputMin, inputMax, outputMin, outputMax) {
		return ((outputMax - outputMin) * ((val - inputMin) / (inputMax - inputMin))) + outputMin;
	}

	/*
	------------------------------------------
	| clamp:number - returns clamped value
	|
	| val:number - value to be clamped
	| min:number - minimum of clamped range
	| max:number - maximum of clamped range
	|
	| Clamp a value to a min/max range.
	------------------------------------------ */
	clamp(val, min, max) {
		return Math.max(Math.min(val, max), min);
	}

	lerp(current, target, mix) {
		return current + (target - current) * mix;
	}

	/*
	------------------------------------------
	| roundToUpperInterval:number - returns rounded up value
	|
	| value:number - value to be rounded
	| interval:number - interval
	|
	| Round up a value to the next highest interval.
	------------------------------------------ */
	roundToUpperInterval(value, interval) {
		if(value % interval === 0) {
			value += 0.0001;
		}
		return Math.ceil(value / interval) * interval;
	}

	/*
	------------------------------------------
	| roundDownToInterval:number - returns rounded down value
	|
	| value:number - value to be rounded
	| interval:number - interval
	|
	| Round down a value to the next lowest interval.
	------------------------------------------ */
	roundToLowerInterval(value, interval) {
		if(value % interval === 0) {
			value -= 0.0001;
		}
		return Math.floor(value / interval) * interval;
	}

	/*
	------------------------------------------
	| roundToNearestInterval:number - returns rounded value
	|
	| value:number - value to be rounded
	| interval:number - interval
	|
	| Round a value to the nearest interval.
	------------------------------------------ */
	roundToNearestInterval(value, interval) {
		return Math.round(value / interval) * interval;
	}

	/*
	------------------------------------------
	| intersectSphere:boolean - returns if intersecting or not
	|
	| a:object - sphere 1 with radius, x, y, and z
	| b:object - sphere 2 with radius, x, y, and z
	|
	| Check if two sphere are intersecting
	| in 3D space.
	------------------------------------------ */
	intersectSphere(a, b) {
		let distance = Math.sqrt(
			(a.x - b.x) * (a.x - b.x) +
			(a.y - b.y) * (a.y - b.y) +
			(a.z - b.z) * (a.z - b.z)
		);
		return distance < (a.radius + b.radius);
	}

	/*
	------------------------------------------
	| getIndexFromCoords:number - returns index
	|
	| x:number - x value (column)
	| y:number - y value (row)
	| w:number - width of grid
	|
	| Convert from grid coords to index.
	------------------------------------------ */
	getIndexFromCoords(x, y, w) {
		return x + (y * w);
	}

	/*
	------------------------------------------
	| getCoordsFromIndex:object - returns coords
	|
	| i:number - index
	| w:number - width of grid
	|
	| Convert from index to grid coords.
	------------------------------------------ */
	getCoordsFromIndex(i, w) {
		return {
			x: i % w,
			y: Math.floor(i / w)
		}
	}

	visibleHeightAtZDepth(depth, camera) {
		// https://discourse.threejs.org/t/functions-to-calculate-the-visible-width-height-at-a-given-z-depth-from-a-perspective-camera/269
		let cameraOffset = camera.position.z;
		if ( depth < cameraOffset ) depth -= cameraOffset;
		else depth += cameraOffset;
		let vFOV = camera.fov * Math.PI / 180; 
		return 2 * Math.tan( vFOV / 2 ) * Math.abs( depth );
	};

	visibleWidthAtZDepth(depth, camera) {
		// https://discourse.threejs.org/t/functions-to-calculate-the-visible-width-height-at-a-given-z-depth-from-a-perspective-camera/269
		let height = this.visibleHeightAtZDepth( depth, camera );
		return height * camera.aspect;
	};

}


class Ease {

	constructor() {

	}

	/*
	------------------------------------------
	| inQuad:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inQuad.
	------------------------------------------ */
	inQuad(t, b, c, d) {
		return c*(t/=d)*t + b;
	}

	/*
	------------------------------------------
	| outQuad:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on outQuad.
	------------------------------------------ */
	outQuad(t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	}

	/*
	------------------------------------------
	| inOutQuad:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inOutQuad.
	------------------------------------------ */
	inOutQuad(t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	}

	/*
	------------------------------------------
	| inCubic:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inCubic.
	------------------------------------------ */
	inCubic(t, b, c, d) {
		return c*(t/=d)*t*t + b;
	}

	/*
	------------------------------------------
	| outCubic:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on outCubic.
	------------------------------------------ */
	outCubic(t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	}

	/*
	------------------------------------------
	| inOutCubic:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inOutCubic.
	------------------------------------------ */
	inOutCubic(t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	}

	/*
	------------------------------------------
	| inQuart:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inQuart.
	------------------------------------------ */
	inQuart(t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	}

	/*
	------------------------------------------
	| outQuart:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on outQuart.
	------------------------------------------ */
	outQuart(t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	}

	/*
	------------------------------------------
	| inOutQuart:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inOutQuart.
	------------------------------------------ */
	inOutQuart(t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	}

	/*
	------------------------------------------
	| inQuint:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inQuint.
	------------------------------------------ */
	inQuint(t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	}

	/*
	------------------------------------------
	| outQuint:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on outQuint.
	------------------------------------------ */
	outQuint(t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	}

	/*
	------------------------------------------
	| inOutQuint:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inOutQuint.
	------------------------------------------ */
	inOutQuint(t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	}

	/*
	------------------------------------------
	| inSine:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inSine.
	------------------------------------------ */
	inSine(t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	}

	/*
	------------------------------------------
	| outSine:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on outSine.
	------------------------------------------ */
	outSine(t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	}

	/*
	------------------------------------------
	| inOutSine:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inOutSine.
	------------------------------------------ */
	inOutSine(t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	}

	/*
	------------------------------------------
	| inExpo:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inExpo.
	------------------------------------------ */
	inExpo(t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	}

	/*
	------------------------------------------
	| outExpo:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on outExpo.
	------------------------------------------ */
	outExpo(t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	}

	/*
	------------------------------------------
	| inOutExpo:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inOutExpo.
	------------------------------------------ */
	inOutExpo(t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	}

	/*
	------------------------------------------
	| inCirc:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inCirc.
	------------------------------------------ */
	inCirc(t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	}

	/*
	------------------------------------------
	| outCirc:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on outCirc.
	------------------------------------------ */
	outCirc(t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	}

	/*
	------------------------------------------
	| inOutCirc:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inOutCirc.
	------------------------------------------ */
	inOutCirc(t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	}

	/*
	------------------------------------------
	| inElastic:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inElastic.
	------------------------------------------ */
	inElastic(t, b, c, d) {
		let s=1.70158;let p=0;let a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; let s=p/4; }
		else s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	}

	/*
	------------------------------------------
	| outElastic:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on outElastic.
	------------------------------------------ */
	outElastic(t, b, c, d) {
		let s=1.70158;let p=0;let a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; let s=p/4; }
		else s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	}

	/*
	------------------------------------------
	| inOutElastic:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	|
	| Get an eased float value based on inOutElastic.
	------------------------------------------ */
	inOutElastic(t, b, c, d) {
		let s=1.70158;let p=0;let a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; let s=p/4; }
		else s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	}

	/*
	------------------------------------------
	| inBack:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	| s:number - strength
	|
	| Get an eased float value based on inBack.
	------------------------------------------ */
	inBack(t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	}

	/*
	------------------------------------------
	| outBack:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	| s:number - strength
	|
	| Get an eased float value based on outBack.
	------------------------------------------ */
	outBack(t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	}

	/*
	------------------------------------------
	| inOutBack:float - returns eased float value
	|
	| t:number - current time
	| b:number - beginning value
	| c:number - change in value
	| d:number - duration
	| s:number - strength
	|
	| Get an eased float value based on inOutBack.
	------------------------------------------ */
	inOutBack(t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	}

}


class AxisHelper {

	constructor(axisLength, opacity) {
		this.object3d = new THREE.Object3D();
		this.axisLength = axisLength;
		this.opacity = opacity;

		this.createAxis(
			new THREE.Vector3(-this.axisLength, 0, 0),
			new THREE.Vector3(this.axisLength, 0, 0),
			new THREE.Color('hsl(0, 100%, 100%)')
		);

		this.createAxis(
			new THREE.Vector3(0, -this.axisLength, 0),
			new THREE.Vector3(0, this.axisLength, 0),
			new THREE.Color('hsl(120, 100%, 100%)')
		);

		this.createAxis(
			new THREE.Vector3(0, 0, -this.axisLength),
			new THREE.Vector3(0, 0, this.axisLength),
			new THREE.Color('hsl(240, 100%, 100%)')
		);

		return this.object3d;
	}

	createAxis(p1, p2, color){
		let geom = new THREE.Geometry();
		let mat = new THREE.LineBasicMaterial({
			color: color,
			opacity: this.opacity,
			transparent: true
		});
		geom.vertices.push(p1, p2);
		let line = new THREE.Line(geom, mat);
		this.object3d.add(line);
	}

}

class Osc {

	constructor(val, rate, dir = true, flip = false) {
		this._val = val;
		this._rate = rate;
		this._dir = dir;
		this._flip = flip;

		this._valBase = val;
		this._rateBase = rate;
		this._dirBase = dir;
		this._flipBase = flip;

		this.trigger = false;
		this.triggerTop = false;
		this.triggerBot = false;
	}

	reset() {
		this._val = this._valBase;
		this._rate = this._rateBase;
		this._dir = this._dirBase;
		this._flip = this._flipBase;

		this.trigger = false;
		this.triggerTop = false;
		this.triggerBot = false;
	}

	update(dt) {
		this.trigger = false;
		this.triggerTop = false;
		this.triggerBot = false;
		if(this._dir) {
			if(this._val < 1) {
				this._val += this._rate * dt;
			} else {
				this.trigger = true;
				this.triggerTop = true;
				if(this._flip) {
					this._val = this._val - 1;
				} else {
					this._val = 1 - (this._val - 1);
					this._dir = !this._dir;
				}
			}
		} else {
			if(this._val > 0) {
				this._val -= this._rate * dt;
			} else {
				this.trigger = true;
				this.triggerBot = true;
				if(this._flip) {
					this._val = 1 + this._val;
				} else {
					this._val = -(this._val);
					this._dir = !this._dir;
				}
			}
		}
	}

	val(ease) {
		if(ease) {
			return ease(this._val, 0, 1, 1);
		} else {
			return this._val;
		}
	}

}


class Loader {

	constructor(System) {
		this.calc = new Calc();
		this.ease = new Ease();

		this.dom = {
			html: document.documentElement,
			container: document.querySelector('.loader')
			
			//debugButton: document.querySelector('.icon--debug')
		}
		this.dom.html.classList.add('loading');

		this.completed = false;
		this.raf = null;

		//this.setupDebug();
		this.setupTime();
		this.setupScene();
		this.setupCamera();
		this.setupRenderer();
		this.setupControls();
		this.setupHelpers();
		this.listen();
		this.onResize();

		this.system = new System(this);
		this.loop();
	}

	setupDebug() {
		this.isDebug = location.hash.indexOf('debug') > 0;
		this.isGrid = location.hash.indexOf('grid') > 0;
		this.isOrbit = location.hash.indexOf('orbit') > 0;

		this.debugHash = '';

		if(this.isDebug) {
			this.isGrid = true;
			this.isOrbit = true;
			this.debugHash += 'debug';
			this.dom.html.classList.add('is-debug');
		} else {
			this.debugHash += this.isGrid ? 'grid' : '';
			this.debugHash += this.isOrbit ? 'orbit' : '';
		}

		if(this.debugHash) {
			[].slice.call(document.querySelectorAll('.demo')).forEach((elem, i, arr) => {
				elem.setAttribute('href', `${elem.getAttribute('href')}#${this.debugHash}`);
			});
		}
	}

	setupTime() {
		this.timescale = 1;
		this.clock = new THREE.Clock();
		this.deltaTimeSeconds = this.clock.getDelta() * this.timescale;
		this.deltaTimeMilliseconds = this.deltaTimeSeconds * 1000;
		this.deltaTimeNormal = this.deltaTimeMilliseconds / (1000 / 60);
		this.elapsedMilliseconds = 0;
	}

	setupScene() {
		this.scene = new THREE.Scene();
	}

	setupCamera() {
		this.camera = new THREE.PerspectiveCamera(100, 0, 0.0001, 10000);

		this.cameraBaseX = this.isGrid ? -20 : 0;
		this.cameraBaseY = this.isGrid ? 15 : 0;
		this.cameraBaseZ = this.isGrid ? 20 : 30;

		this.camera.position.x = this.cameraBaseX;
		this.camera.position.y = this.cameraBaseY;
		this.camera.position.z = this.cameraBaseZ;
	}

	setupRenderer() {
		this.renderer = new THREE.WebGLRenderer({
			alpha: true,
			antialias: true
		});

		this.dom.container.appendChild(this.renderer.domElement);
	}

	setupControls() {
		if(this.isOrbit) {
			this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
			this.controls.enableDamping = true;
			this.controls.dampingFactor = 0.2;
			this.controls.enableKeys = false;

			this.dom.timescaleWrap.style.visibility = 'visible';
		}
	}

	setupHelpers() {
		if(this.isGrid) {
			this.gridOpacityMap = [
				0.4, // 1
				0.2, // 2
				0.2, // 3
				0.2, // 4
				0.1, // 5
				0.2, // 6
				0.1, // 7
				0.1  // 8
			];
			this.gridHelper = new THREE.GridHelper(300, 60, 0xffffff, 0xffffff);
			this.gridHelper.material.transparent = true;
			this.gridHelper.material.opacity = this.gridOpacityMap[demoNum - 1];
			this.scene.add(this.gridHelper);

			this.axisOpacityMap = [
				1, // 1
				0.6, // 2
				0.6, // 3
				0.6, // 4
				0.3, // 5
				0.6, // 6
				0.3, // 7
				0.3  // 8
			];
			this.axisHelper = new AxisHelper(150, this.axisOpacityMap[demoNum - 1]);
			this.scene.add(this.axisHelper);

			this.camera.lookAt(new THREE.Vector3());
		}
	}

	update() {
		this.deltaTimeSeconds = this.clock.getDelta();
		if(this.diffTime) {
			this.deltaTimeSeconds -= this.diffTime;
			this.diffTime = 0;
		}
		this.deltaTimeSeconds *= this.timescale;
		this.deltaTimeMilliseconds = this.deltaTimeSeconds * 1000;
		this.deltaTimeNormal = this.deltaTimeMilliseconds / (1000 / 60);
		this.elapsedMilliseconds += this.deltaTimeMilliseconds;

		this.system.update();

		if(this.isOrbit) {
			this.controls.update();
		}
	}

	render() {
		this.renderer.render(this.scene, this.camera);
	}

	listen() {
		window.addEventListener('resize', (e) => this.onResize(e));

		

		if(this.isOrbit) {
		}

		this.hidden = null;
		this.visibilityChange = null;
		if(typeof document.hidden !== 'undefined') {
			this.hidden = 'hidden';
			this.visibilityChange = 'visibilitychange';
		} else if(typeof document.msHidden !== 'undefined') {
			this.hidden = 'msHidden';
			this.visibilityChange = 'msvisibilitychange';
		} else if(typeof document.webkitHidden !== 'undefined') {
			this.hidden = 'webkitHidden';
			this.visibilityChange = 'webkitvisibilitychange';
		}
		if(typeof document.addEventListener === 'undefined' || typeof document.hidden === 'undefined') {
		} else {
			window.addEventListener(this.visibilityChange, (e) => this.onVisibilityChange(e));
		}
	}

	replay() {
		document.documentElement.classList.remove('completed');
		document.documentElement.classList.add('loading');

		this.camera.position.x = this.cameraBaseX;
		this.camera.position.y = this.cameraBaseY;
		this.camera.position.z = this.cameraBaseZ;

		this.timescale = 1;
		this.deltaTimeSeconds = 1 / 60;
		this.deltaTimeMilliseconds = this.deltaTimeSeconds * 1000;
		this.deltaTimeNormal = this.deltaTimeMilliseconds / (1000 / 60);
		this.elapsedMilliseconds = 0;
		this.blurTime = 0;
		this.diffTime = 0;
		this.focusTime = 0;

		this.system.replay();
		this.completed = false;
		this.clock.start();
		this.loop();
	}

	complete() {
		if(this.isOrbit || this.isGrid) {
			return;
		}
		setTimeout(() => {
			this.clock.stop();
			cancelAnimationFrame(this.raf);
		}, 600);
		this.completed = true;
		this.dom.html.classList.remove('loading');
		this.dom.html.classList.add('completed');
	}

	onResize() {
		this.width = window.innerWidth;
		this.height = window.innerHeight;
		this.dpr = window.devicePixelRatio > 1 ? 2 : 1

		this.camera.aspect = this.width / this.height;
		this.camera.updateProjectionMatrix();

		this.renderer.setPixelRatio(this.dpr);
		this.renderer.setSize(this.width, this.height);
	}

	onReplayButtonClick(e) {
		e.preventDefault();
		this.replay();
	}

	onDebugButtonClick(e) {
		e.preventDefault();
		let baseURL = window.location.href.split('#')[0];
		if(this.isDebug) {
			if(history) {
				history.pushState('', document.title, window.location.pathname);
			} else {
				location.hash = '';
			}
			location.href = baseURL;
		} else {
			location.href = `${baseURL}#debug`;
		}
		location.reload();
	}

	onTimescaleRangeChange(e) {
		this.timescale = parseFloat(this.dom.timescaleRange.value);
		this.dom.timescaleValue.innerHTML = this.timescale.toFixed(1);
	}

	onVisibilityChange(e) {
		if(document.hidden) {
			this.blurTime = Date.now();
		} else {
			this.focusTime = Date.now();
			if(this.blurTime) {
				this.diffTime = (this.focusTime - this.blurTime) / 1000;
			}
		}
	}

	loop() {
		this.update();
		this.render();
		this.raf = window.requestAnimationFrame(() => this.loop());
	}

}


class SystemBase {

	constructor(loader) {
		this.loader = loader;

		this.calc = this.loader.calc;
		this.ease = this.loader.ease;

		this.sphereGeometry = new THREE.SphereBufferGeometry(1, 16, 16);
		this.boxGeometry = new THREE.BoxBufferGeometry(1, 1, 1);
		this.center = new THREE.Vector3();

		this.particles = [];
		this.particleGroup = new THREE.Object3D();
		this.particleGroup.scale.set(0.0001, 0.0001, 0.0001);

		this.loader.scene.add(this.particleGroup);

		this.entering = true;
		this.enterProgress = 0;
		this.enterRate = 0.015;

		this.exiting = false;
		this.exitProgress = 0;
		this.exitRate = 0.01;
		this.duration = Infinity;
	}

	update() {
		let i = this.particles.length;
		while(i--) {
			this.particles[i].update();
		}

		if(this.entering && this.enterProgress < 1) {
			this.enterProgress += this.enterRate * this.loader.deltaTimeNormal;
			if(this.enterProgress > 1) {
				this.enterProgress = 1;
				this.entering = false;
			}
			let scale = this.ease.inOutExpo(this.enterProgress, 0, 1, 1);
			this.particleGroup.scale.set(scale, scale, scale);
		}

		if(!this.exiting && this.loader.elapsedMilliseconds > this.duration) {
			this.exiting = true;
		}

		if(this.exiting) {
			this.exitProgress += this.exitRate * this.loader.deltaTimeNormal;
			if(this.exitProgress >= 1 && !this.loader.completed) {
				this.exitProgress = 1;
				//this.loader.complete();
			}
		}
	}

	replay() {
		this.particleGroup.scale.set(0.0001, 0.0001, 0.0001);

		let i = this.particles.length;
		while(i--) {
			this.particles[i].reset();
		}

		this.entering = true;
		this.enterProgress = 0;

		this.exiting = false;
		this.exitProgress = 0;
	}

}


class ParticleBase {

	constructor(config, system, loader) {
		this.system = system;
		this.loader = loader;

		this.calc = this.loader.calc;
		this.ease = this.loader.ease;

		this.group = config.group;
		this.x = config.x;
		this.y = config.y;
		this.z = config.z;
		this.size = config.size;
		this.color = config.color;
		this.opacity = config.opacity;

		this.createMesh();
	}

	createMesh() {
		this.geometry = this.system.sphereGeometry;

		this.material = new THREE.MeshBasicMaterial({
			color: this.color,
			transparent: true,
			opacity: this.opacity,
			depthTest: false,
			precision: 'lowp'
		});

		this.mesh = new THREE.Mesh(this.geometry, this.material);

		this.mesh.position.x = this.x;
		this.mesh.position.y = this.y;
		this.mesh.position.z = this.z;

		this.mesh.scale.set(this.size, this.size, this.size);

		this.group.add(this.mesh);
	}

	reset() {}

}


class Particle extends ParticleBase {

	constructor(config, system, loader) {
		super(config, system, loader);

		this.alternate = config.alternate;
		this.noiseScale = 0.15
		this.amplitude = 0;
		this.speed = 0;
	}

	update() {
		if(this.alternate) {
			this.amplitude = ((this.system.size / 2) - Math.abs(this.mesh.position.x)) / (this.system.size / 2);
			this.amplitude *= this.system.osc1Eased;
			this.speed = this.loader.elapsedMilliseconds / 750;
			this.mesh.position.y = this.system.simplex.getRaw2DNoise(this.mesh.position.x * this.noiseScale + this.speed, 0) * 10 * this.amplitude;
		} else {
			this.amplitude = ((this.system.size / 2) - Math.abs(this.mesh.position.x)) / (this.system.size / 2);
			this.amplitude *= 1 - this.system.osc1Eased;
			this.speed = this.loader.elapsedMilliseconds / 750;
			this.mesh.position.y = this.system.simplex.getRaw2DNoise(this.mesh.position.x * this.noiseScale + this.speed + 1000, 1000) * 10 * this.amplitude;
		}

		let size = 0.05 + this.size * this.amplitude;
		this.mesh.material.opacity = 0.1 + this.amplitude * 0.9;
		size = 0.05 + 0.1 * this.amplitude;
		this.mesh.scale.set(size, size, size);

		this.mesh.position.z = this.alternate ? 0.05 + 10 * this.amplitude : -(0.05 + 10 * this.amplitude);
	}

}


class System extends SystemBase {

	constructor(loader) {
		super(loader);

		this.duration = 7700;
		this.simplex = new FastSimplexNoise();
		this.count = 300;
		this.size = 30;

		for(let i = 0; i < this.count; i++) {
			let x = this.calc.map(i, 0, this.count , -this.size / 2, this.size / 2) + (this.size / this.count / 2);
			let y = 0;
			let z = 0;

			this.particles.push(new Particle({
				group: this.particleGroup,
				x: x,
				y: y,
				z: z,
				size: this.calc.map(Math.abs(x), 0, this.size / 2, 0.2, 0.01),
				color: i % 2 === 0 ? 0xffffff : 0x56311e,
				opacity: 1,
				alternate: i % 2 === 0
			}, this, this.loader));
		}

		this.osc1 = new Osc(0.2, 0.015);
		this.osc2 = new Osc(0, 0.015, true, false);

		this.reset();
	}

	reset() {
		this.osc1.reset();
		this.osc1Eased = 0;
		this.osc2.reset();
		this.rotationZTarget = 0;
		this.lastRotationZTarget = this.rotationZTarget;
		this.rotationZProgress = 0;
	}

	replay() {
		super.replay();
		this.reset();
	}

	update() {
		super.update();

		this.osc1.update(this.loader.deltaTimeNormal);
		this.osc1Eased = this.osc1.val(this.ease.inOutExpo);
		this.osc2.update(this.loader.deltaTimeNormal);

		if(this.osc2.triggerBot) {
			this.lastRotationZTarget = this.rotationZTarget;
			this.rotationZTarget += Math.PI / -2;
			this.rotationZProgress = this.rotationZProgress - 1;
		}

		if(this.rotationZProgress < 1) {
			this.rotationZProgress += 0.025 * this.loader.deltaTimeNormal;
		}
		this.rotationZProgress = this.calc.clamp(this.rotationZProgress, 0, 1);

		this.particleGroup.rotation.z = this.calc.map(this.ease.inOutExpo(this.rotationZProgress, 0, 1, 1), 0, 1, this.lastRotationZTarget, this.rotationZTarget);

		if(this.exiting && !this.loader.isOrbit && !this.loader.isGrid) {
			this.loader.camera.position.z = this.loader.cameraBaseZ - this.ease.inExpo(this.exitProgress, 0, 1, 1) * this.loader.cameraBaseZ;
		}
	}

}


window.demoNum = 2;

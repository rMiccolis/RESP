
let clientResolution = window.screen.height;

let rendererWidth;
let rendererHeight;

if (clientResolution >= 1440) {

    rendererWidth = 550;
    rendererHeight = 556;
} else {
    rendererHeight = 555;
    rendererWidth = 500;
}




let clickable = false;

let device = "PC";


if (navigator.userAgent.match(/Android/i)
    || navigator.userAgent.match(/webOS/i)
    || navigator.userAgent.match(/iPhone/i)
    || navigator.userAgent.match(/iPad/i)
    || navigator.userAgent.match(/iPod/i)
    || navigator.userAgent.match(/BlackBerry/i)
) {
    device = "mobile";
}

if (device == "mobile") {
    rendererHeight = 250;
    rendererWidth = 350;
}

//camera position to swap, used in ChangeCameraPosition
let targetMid = new THREE.Vector3(0, 5, 0);
let targetUp = new THREE.Vector3(0, 9, 0);
let targetDown = new THREE.Vector3(0, 0, 0);


//objects to add listners to each mesh
var raycaster = new THREE.Raycaster();
var mouse = new THREE.Vector2();


// Initial material
const INITIAL_MTL = new THREE.MeshPhongMaterial({
    color: 0xf1f1f1,
    shininess: 10
});

//variables containing mesh color material based on pain felt by patient
const nessun_dolore = new THREE.MeshPhongMaterial({
    color: parseInt('0x00FF00'),
    shininess: 10
});

const dolore_lieve = new THREE.MeshPhongMaterial({
    color: parseInt('0x80ccff'),
    shininess: 10
});

const dolore_moderato = new THREE.MeshPhongMaterial({
    color: parseInt('0x2323d2'),
    shininess: 10
});

const dolore_intenso = new THREE.MeshPhongMaterial({
    color: parseInt('0x8a2070'),
    shininess: 10
});

const dolore_forte = new THREE.MeshPhongMaterial({
    color: parseInt('0x7a0026'),
    shininess: 10
});

const dolore_molto_forte = new THREE.MeshPhongMaterial({
    color: parseInt('0xff0000'),
    shininess: 10
});

const hover_color = new THREE.MeshPhongMaterial({
    color: parseInt('0xdaffa3'),
    shininess: 10
});

//variable containing the selected color by the user
let selected_color = {
    "nome_dolore": "nessun_dolore",
    "material": nessun_dolore
}

//function used inside taccuino.blade to let the user select the color wanted
function changeSelectedColor(color) {
    switch (color) {
        case '#00ff00':
            selected_color = {
                "nome_dolore": "nessun_dolore",
                "material": nessun_dolore
            };
            break;
        case '#ffffff':
            selected_color = {
                "nome_dolore": "dolore_lieve",
                "material": dolore_lieve
            };
            break;
        case '#2323d2':
            selected_color = {
                "nome_dolore": "dolore_moderato",
                "material": dolore_moderato
            };
            break;
        case '#8a2070':
            selected_color = {
                "nome_dolore": "dolore_intenso",
                "material": dolore_intenso
            };
            break;
        case '#7a0026':
            selected_color = {
                "nome_dolore": "dolore_forte",
                "material": dolore_forte
            };
            break;
        case '#ff0000':
            selected_color = {
                "nome_dolore": "dolore_molto_forte",
                "material": dolore_molto_forte
            };
            break;
        default:
            selected_color = {
                "nome_dolore": "nessun_dolore",
                "material": nessun_dolore
            };
    }

};
//function used inside dolore.js. to understand which color to assign to the reading mesh
function readSelectedColor(selected_color) {
    let color;
    switch (selected_color) {
        case 'nessun_dolore':
            color = nessun_dolore;
            break;
        case 'dolore_lieve':
            color = dolore_lieve;
            break;
        case 'dolore_moderato':
            color = dolore_moderato;
            break;
        case 'dolore_intenso':
            color = dolore_intenso;
            break;
        case 'dolore_forte':
            color = dolore_forte;
            break;
        case 'dolore_molto_forte':
            color = dolore_molto_forte;
            break;
        default:
            color = INITIAL_MTL;
    }
    return color;
};

//initial selected color (white)
let init = {
    'nome_dolore': 'INITIAL_MTL',
    'material': INITIAL_MTL
};

//variable that will point to the 3D model
var theModel;


const MODEL_PATH = "Man_3D.glb";
let numberOfMeshes = 1512; //unused



//variable to understand if initial rotation has ended
var loaded = false;

//number of activated meshes, unused but may be useful in future
let activated = 0;

/* array of json containing additional info about meshes on the 3D man
*  each json object in the array contains:
*  - name (the name of the mesh)
*  - activated (indicates if the mesh has been clicked or not)
*  - hovered (indicates if the mouse pointer just went on the mesh without clicking it)
*  - dolore (the name of the pain indicated by user on the RESP)
*/
selectedPlaces = [
];


//const BACKGROUND_COLOR = 0xf1f1f1;
const BACKGROUND_COLOR = 0x9DBAFF;
// Init the scene
const scene = new THREE.Scene();
// Set background
scene.background = new THREE.Color(BACKGROUND_COLOR);
scene.fog = new THREE.Fog(BACKGROUND_COLOR, 1, 100);

const canvas = document.querySelector('#c');

// Init the renderer
const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });

renderer.shadowMap.enabled = true;
renderer.setPixelRatio(window.devicePixelRatio);
let insertCanvas = document.getElementById("3d_canv");


let home_page_canvas = document.getElementById("home_page_canvas");

//this is the element in the page taccuino which has to host the 3D man (homepage)
home_page_canvas.appendChild(renderer.domElement);


//give initial style to the canvas
canvas.style.position = "relative";
canvas.style.top = "1%";

canvas.style.zIndex = "500";

//set the max distance from the man inside the 3D scene
var cameraFar = 15;

// Add a camerra
var camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.z = cameraFar;
camera.position.x = 2;
camera.position.y = 8;

//array containing json of meshes containing only INITIAL mesh name and the material to be set
const INITIAL_MAP = [

];

//array containing mesh objects to be passed to the raycaster method to work properly
let mesh_objects = [];

// Init the object loader
var loader = new THREE.GLTFLoader();

//loads the model
loader.load(MODEL_PATH, function (gltf) {
    theModel = gltf.scene;
    // console.log(theModel.children.length);
    theModel.traverse(o => { //this function iterates over each object of the model
        if (o.isMesh) {
            o.castShadow = true;
            o.receiveShadow = true;
            INITIAL_MAP.push({ childID: o.name, mtl: INITIAL_MTL });
            mesh_objects.push(o);
            selectedPlaces.push({ name: o.name, activated: false, hovered: false, dolore: init.nome_dolore });

        }
    });

    // Set the models initial scale   
    theModel.scale.set(3, 3, 3);
    theModel.rotation.y = Math.PI;

    // Offset the y position a bit
    theModel.position.y = -1;


    // Set initial textures
    for (let object of INITIAL_MAP) {
        initColor(theModel, object.childID, object.mtl);
    }

    // Add the model to the scene
    scene.add(theModel);

}, undefined, function (error) {
    console.error(error);
});


//function to manage left click (or tap from mobile) on the model
//object is the mesh clicked on theModel
let add_click_touch = function (object) {

    let i = 0;

    while (i < selectedPlaces.length) {

        if (selectedPlaces[i].name == object.nameID) {

            if (selectedPlaces[i].activated == true) {
                selectedPlaces[i].activated = false;
                selectedPlaces[i].hovered = false;

                activated--;

                setMaterial(theModel, object.nameID, INITIAL_MTL);
                selectedPlaces[i].dolore = init.nome_dolore;
            } else {
                selectedPlaces[i].activated = true;
                selectedPlaces[i].hovered = false;

                activated++;

                setMaterial(theModel, object.nameID, selected_color.material);
                selectedPlaces[i].dolore = selected_color.nome_dolore;
            }
            break;
        }
        i++;
    }
};

// Function - Add the textures to the models
function initColor(parent, type, mtl) {
    parent.traverse(o => {
        if (o.isMesh) {
            if (o.name.includes(type)) {

                o.material = mtl;
                o.nameID = type; // Set a new property to identify this object

            }
        }
    });
}

// Add lights to the scene
var hemiLight = new THREE.HemisphereLight(0xffffff, 0xffffff, 0.61);
hemiLight.position.set(0, 50, 0);
// Add hemisphere light to scene   
scene.add(hemiLight);


//light from the front of the man
var dirLight = new THREE.DirectionalLight(0xffffff, 0.54);
dirLight.position.set(-8, 12, 20);
dirLight.castShadow = true;
dirLight.shadow.mapSize = new THREE.Vector2(1024, 1024);
dirLight.shadow.camera = new THREE.OrthographicCamera(-5, 4, 10, -10, 0.1, 1000);
// Add directional Light to scene    
scene.add(dirLight);

//light from behind the man
var dirLight2 = new THREE.DirectionalLight(0xffffff, 0.54);
dirLight2.position.set(8, -12, -20);
dirLight2.castShadow = true;
dirLight2.shadow.mapSize = new THREE.Vector2(1024, 1024);
// Add directional Light to scene    
scene.add(dirLight2);


// Floor
var floorGeometry = new THREE.PlaneGeometry(6000, 6000, 70, 70);
var floorMaterial = new THREE.MeshPhongMaterial({
    color: 0xFFFFFF,
    shininess: 0
});


var floor = new THREE.Mesh(floorGeometry, floorMaterial);
floor.rotation.x = -0.5 * Math.PI;
floor.receiveShadow = true;
floor.position.y = -1;
scene.add(floor);

// Add controls
var controls = new THREE.OrbitControls(camera, renderer.domElement);
controls.maxPolarAngle = Math.PI;
controls.minPolarAngle = Math.PI / 30;
controls.enableDamping = true;
controls.enablePan = false;
controls.minDistance = 3;
controls.maxDistance = 25;
controls.dampingFactor = 0.04;
controls.rotateSpeed = 0.8;
controls.autoRotate = false;
controls.autoRotateSpeed = 0.5; // 30
controls.target = new THREE.Vector3(0, 5, 0);
controls.mouseButtons = {
    LEFT: THREE.MOUSE.PAN,
    // MIDDLE: THREE.MOUSE.DOLLY,
    RIGHT: THREE.MOUSE.ROTATE
}


//function to manage click onto the 3D man
function onMouseClick(event) {
    event.preventDefault();
    lastEventWas3D = 1;
    // mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    // mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;
    var rect = renderer.domElement.getBoundingClientRect();
    mouse.x = ((event.clientX - rect.left) / (rect.right - rect.left)) * 2 - 1;
    mouse.y = - ((event.clientY - rect.top) / (rect.bottom - rect.top)) * 2 + 1;


    raycaster.setFromCamera(mouse, camera);
    var intersects = raycaster.intersectObjects(mesh_objects);

    if (intersects.length > 0) {
        add_click_touch(intersects[0].object);
    }
}



//function to highlight meshes when mouse is over them
function hoverMesh(mesh) {
    for (let obj of selectedPlaces) {
        if (obj.name == mesh.nameID && obj.activated == false && obj.hovered == false) {

            setMaterial(theModel, mesh.nameID, hover_color);
            lastHovered = obj;
            obj.hovered = true;

        } else if (obj.name != mesh.nameID && obj.activated == false && obj.hovered == true) {
            setTimeout(function () {
                obj.hovered = false;
                setMaterial(theModel, obj.name, INITIAL_MTL);
            }, 50);
        }
    }
}

//variable that stores the last hovered mesh
let lastHovered;
function onMouseMove(event) {
    // mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    // mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;
    var rect = renderer.domElement.getBoundingClientRect();
    mouse.x = ((event.clientX - rect.left) / (rect.right - rect.left)) * 2 - 1;
    mouse.y = - ((event.clientY - rect.top) / (rect.bottom - rect.top)) * 2 + 1;

    raycaster.setFromCamera(mouse, camera);
    var intersects = raycaster.intersectObjects(mesh_objects);
    if (intersects.length > 0) {
        hoverMesh(intersects[0].object);
    } else if (lastHovered != undefined && lastHovered.activated == false) {
        setMaterial(theModel, lastHovered.name, INITIAL_MTL);
    }
}

//function to set all meshes to the white color
function eraseAll() {

    for (let obj of selectedPlaces) {
        setMaterial(theModel, obj.name, INITIAL_MTL);
        obj.dolore = init.nome_dolore;
        obj.activated = false;
        obj.hovered = false;

    }
}

//function to swap camera position on three different height levels
function changeCamPosition() {
    lastEventWas3D = 1;
    if (controls.target.y == targetMid.y) {
        controls.target.y = targetUp.y;
    } else if (controls.target.y == targetUp.y) {
        controls.target.y = targetDown.y;
    } else {
        controls.target.y = targetMid.y;
    }
    controls.update();
    // return false;
}

//if the last object clicked was the 3D canvas, then deactivate right
//click to open context menu
function preventAction(e) {
    if (lastEventWas3D) {
        e.preventDefault();
    }
    // if ($('#c').is(":visible")) {
    //     e.preventDefault();
    // }

}

//variable to count how many right click have been pressed
//to know if user double clicked
var countRightClick = 0;
//changes cam position if double right click or mouse wheel were pressed
function DoubleRightClickScroll(event) {
    lastEventWas3D = 1;
    if (event.button == 1 || event.button == 4) { //event.button = 1 means scroll mouse button was pressed (4 on internet explorer)
        changeCamPosition();
        return false;
    }
    if (event.button == 2) { //event.button = 2 means right click
        countRightClick++;
        setTimeout(resetRightClick, 200);
        if (countRightClick > 1) {
            changeCamPosition();
            resetRightClick();
        }
    }
    return false;

}
function resetRightClick() {
    countRightClick = 0;
}


//variable to keep track if user double taps on screen
var countTouchStart = 0;
//mesh to be deactivated cause of accidental tap (zoom or double click)
var lastActivated;
//function to swap camera with double tap and select meshes on 3D model from mobile
function onTouchClick(event) {

    var rect = renderer.domElement.getBoundingClientRect();
    mouse.x = ((event.targetTouches[0].clientX - rect.left) / (rect.right - rect.left)) * 2 - 1;
    mouse.y = - ((event.targetTouches[0].clientY - rect.top) / (rect.bottom - rect.top)) * 2 + 1;

    // mouse.x = (event.touches[0].pageX / window.innerWidth) * 2 - 1;
    // mouse.y = - (event.touches[0].pageY / window.innerHeight) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);
    var intersects = raycaster.intersectObjects(mesh_objects);


    //means that user is zooming, so we don't want mesh to be activated
    if (event.touches.length == 2 && intersects.length > 0 && lastActivated) {

        setMaterial(theModel, lastActivated.nameID, INITIAL_MTL);

        return false;
    }

    countTouchStart++;
    setTimeout(resetTouchStart, 120);
    if (countTouchStart > 1 && event.touches.length == 1) {
        //means that double tap has been fired and deactivating the accidental activated mesh
        if (lastActivated) {
            setMaterial(theModel, lastActivated.nameID, INITIAL_MTL);
        }
        changeCamPosition();
        resetTouchStart();
        return false;
    }



    if (intersects.length > 0) {
        add_click_touch(intersects[0].object);
        lastActivated = intersects[0].object;
    }
}

function resetTouchStart() {
    countTouchStart = 0;
}
//is == 1 if last click was pressed on the 3D canvas
var lastEventWas3D = 0;

function addLastEventWas3D(event) {
    lastEventWas3D = 1;
}

function showHideContextMenu(event) {
    if (event.target.id != "c") {
        lastEventWas3D = 0;
    }
}

function cancella3D() {
    var m = confirm("Cancellare le modifiche selezionate?");
    if (m) {
        eraseAll();
    }

}

canvas.addEventListener('mousedown', DoubleRightClickScroll, false);
canvas.addEventListener('click', onMouseClick, false);
canvas.addEventListener('contextmenu', addLastEventWas3D, false);
canvas.addEventListener('touchstart', onTouchClick, false);
canvas.addEventListener('mousemove', onMouseMove, false);
document.body.addEventListener('contextmenu', preventAction, false);
document.body.addEventListener('click', showHideContextMenu, false);






//function for dropdown download buttons

/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function dropDownToggle(idTaccuino) {
    let el = document.getElementById("myDrop_" + idTaccuino);

    let drops = document.getElementsByClassName('large');
    for (drop of drops) {
        if (drop.classList.contains("show")) {
            drop.classList.remove("show");
        }
    }


    // console.log(el);
    el.classList.toggle("show");
    if (el.classList.contains("show")) {
        document.getElementById("c").style.zIndex = 0;
    } else {
        document.getElementById("c").style.zIndex = 500;
    }
    // document.getElementById("c").style.zIndex = 1;
}

function setZindex() {
    let el = document.getElementsByClassName("large");
    let active = true;
    for (element of el) {
        if (element.classList.contains("show")) {
            active = false;
            document.getElementById("c").style.zIndex = 0;
        }
    }
    if (active == true) {

        document.getElementById("c").style.zIndex = 500;
    }
}

document.body.addEventListener('mousemove', setZindex, false);

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {


    if (!event.target.matches('.dropButton')) {

        var dropdowns = document.getElementsByClassName("large");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}




$(document).ready(function () {

    if (clientResolution >= 1440) {

        $('#taccuino').css({ "height": "20%", "max-height": "50%" });
    } else {
        $('#taccuino').css({ "height": "10%", "max-height": "70%" });
    }



    if (device == "mobile") {
        console.log("jeiè");
        $('.modal-body').css({ 'overflow-y': 'auto' });
        $('.large').css({ 'max-height': '900px', 'bottom': '0px' });
    }


    $('.modal').on('hidden.bs.modal', function (e) {
        eraseAll();
        setBigSize3Dmodel = true;
        clickable = false;
        //console.log("Closed");
        home_page_canvas.appendChild(renderer.domElement);
        $("#c").show();
        canvas.style.position = "relative";
        canvas.style.top = "1%";
        // canvas.style.left = "30%";
        canvas.style.zIndex = "500";
        let showButtons = document.getElementsByClassName('showpain');

        for (button of showButtons) {
            $(button).removeClass('selected');
        }

    });

    $('.modal').on('shown.bs.modal', function (e) {
        $("#canvas_dolore_back").hide();
        $("#canvas_dolore").hide();
        $("#c").show();
        clickable = true;
        eraseAll();
        let taccuino_modal = document.getElementById("taccuino");
        taccuino_modal.style.height = "85%";
        setBigSize3Dmodel = false;


        let a = insertCanvas.appendChild(renderer.domElement);

        let homeCanvas = document.getElementsByClassName("homeCanvas")[0];
        let modalCanvas = document.getElementsByClassName("modalCanvass")[0];

        homeCanvas.style.zIndex = "0";


        // modalCanvas.style.zIndex = "500";

        canvas.style.position = "relative";
        canvas.style.width = "50 %";
        canvas.style.height = "80 %";
        canvas.style.display = "block";
        // canvas.style.top = "10px";
        canvas.style.left = "0px";


    });

});




function animate() {

    controls.update();

    //resize scene if display size changes
    if (resizeRendererToDisplaySize(renderer)) {
        const canvas = renderer.domElement;
        camera.aspect = canvas.clientWidth / canvas.clientHeight;
        //Updates the camera projection matrix
        camera.updateProjectionMatrix();
    }

    renderer.render(scene, camera);

    //creates a loop that calls animate() to refresh content
    requestAnimationFrame(animate);


    //useful to run the initial rotation
    if (theModel != null && loaded == false) {
        initialRotation();
    }

}


let initRotate = 0;
animate();
var setBigSize3Dmodel = true;
// Function - New resizing method
function resizeRendererToDisplaySize(renderer) {
    const canvas = renderer.domElement;
    var width = window.innerWidth;
    var height = window.innerHeight;
    var canvasPixelWidth = canvas.width / window.devicePixelRatio;
    var canvasPixelHeight = canvas.height / window.devicePixelRatio;

    const needResize = canvasPixelWidth !== width || canvasPixelHeight !== height;
    if (needResize) {
        if (device == "mobile") {
            renderer.setSize(rendererWidth, rendererHeight);
            return needResize;
        }

        if (setBigSize3Dmodel == true) {
            renderer.setSize(550, 830);
        } else {
            renderer.setSize(500, rendererHeight);
        }

        // renderer.setSize(width / 2, height / 2);
    }
    return needResize;
}




//function to change material or color of a mesh
function setMaterial(parent, type, mtl) {
    if (clickable) {
        parent.traverse(o => {
            if (o.isMesh && o.nameID != null) {

                if (o.nameID == type) {
                    o.material = mtl;
                }
            }
        });
    }
}


// Function - Opening rotate
function initialRotation() {


    initRotate++;
    if (initRotate <= 175) {
        theModel.rotation.y += Math.PI / 90;
    } else {
        loaded = true;
    }
}


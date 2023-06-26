// const dr = document.getElementById("rechercheOffre");
// const de = document.getElementById("DomaineExerce");

// const selectDE = document.getElementById('DE');
// const selectDR = document.getElementById('DR');


const fileInput = document.querySelector('#file-input');
// const fileInput1 = document.querySelector('#file-input1');
const progressBar = document.querySelector('#progress-bar');
// const progressBar1 = document.querySelector('#progress-bar1');
const fileErrorMessage = document.querySelector('#file-error-message');
// const fileErrorMessage1 = document.querySelector('#file-error-message1');

// de.style.display = "none";
// dr.style.display = "none";

// selectDE.addEventListener('change', function () {
    
//     // Récupère la valeur de l'option sélectionnée
//     const selectedOption = this.value;

//     switch (selectedOption) {
//         case "autre":
//             de.style.display = "block";
//         break;
    
//         default:
//             de.style.display = "none";
//         break;
//     }
// });

// selectDR.addEventListener('change', function () {
    
//     // Récupère la valeur de l'option sélectionnée
//     const selectedOption = this.value;

//     switch (selectedOption) {
//         case "autre":
//             dr.style.display = "block";
//         break;
    
//         default:
//             dr.style.display = "none";
//         break;
//     }
// });


fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    const fileSize = file.size;
    const fileType = file.type;

    if (fileSize > 100 * 1024 * 1024) {
        fileErrorMessage.textContent = 'Le fichier dépasse la taille maximale autorisée (100 Mo).';
        progressBar.value = 0;
        fileInput.value = "";
        return;
    }
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../../../Hive/API/dataManager/create.php');
    
    xhr.upload.addEventListener('progress', (event) => {
        const percentage = (event.loaded / fileSize) * 100;
        progressBar.value = percentage;
    });

    xhr.send(file);
});

// fileInput1.addEventListener('change', (e) => {
//     const file = e.target.files[0];
//     const fileSize = file.size;
//     const fileType = file.type;
    
//     if (fileSize > 10 * 1024 * 1024) {
//         fileErrorMessage.textContent = 'Le fichier dépasse la taille maximale autorisée (10 Mo).';
//         progressBar1.value = 0;
//         fileInput1.value = "";
//         return;
//     }
//     const xhr = new XMLHttpRequest();
//     xhr.open('POST', '../../API/dataManager/create.php');
    
//     xhr.upload.addEventListener('progress', (event) => {
//         const percentage = (event.loaded / fileSize) * 100;
//         progressBar1.value = percentage;
//     });

//     xhr.send(file);
// });
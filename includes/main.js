//document.getElementById('button').addEventListener('click', loadData);
//
//function loadData() {
//
//    console.log(1);
//    //create an XHR object
//    const xhr = new XMLHttpRequest();
//
//    // Open
//    xhr.open('GET','data.txt',true);
//
//    xhr.onload = function() {
//        if(this.status == 200) {
//            console.log(this.responseText);
//        }
//    }
//
//    xhr.send();
//}
//
//document.getElementById('button1').addEventListener('dblclick', loadMoreData);
//
//function loadMoreData() {
//
//    xhr = new XMLHttpRequest();
//
//    xhr.open('GET', 'customers.json', true);
//
//    xhr.onload = function() {
//
//        if(xhr.status === 200) {
//         const userData = JSON.parse(this.responseText);
//         let output = '';
//
//            userData.forEach( (customer) => {
//            output += `
//            <ul>
//                <li>${customer.id}</li>
//                <li>${customer.name}</li>
//                <li>${customer.company}</li>
//                <li>${customer.phone}</li>
//                 </ul>   `;
//
//            })
//
//            document.getElementById('output').innerHTML = output;
//
//
//        }
//
//    }
//
//    xhr.send();
//
//}

document.getElementById('button3').addEventListener('click', getPeopleinSpace);

function getPeopleinSpace() {
    xhr = new XMLHttpRequest();

    xhr.open('GET', 'http://api.open-notify.org/astros.json',true);

    xhr.onload = function() {
        if(this.status === 200) {
           let output = '';
//            console.log(this.responseText);
            const response = JSON.parse(this.responseText);
//            console.log(response.number);
//            console.log(response.people);
            response.people.forEach( (astro) => {
//                console.log(astro.name);
                output += `
                <ul>
                    <li>${astro.name}</li>
                    <li>${astro.craft}</li>
                </ul>
                `;
            })

//        console.log(output);
        document.getElementById('output').innerHTML = output;

            }
    }

    xhr.send();
}

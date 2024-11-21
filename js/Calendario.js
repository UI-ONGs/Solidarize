// Variável global para armazenar o número de arquivos
let fileCount = 0;

// Seleciona o elemento de upload de arquivos globalmente
const fileUploadElement = document.getElementById('file-upload');

// Função para contar os arquivos selecionados
fileUploadElement.addEventListener('change', function () {
    fileCount = this.files.length;
    var fileCountSpan = document.querySelector('.file-count');
    if (fileCount === 1) {
        fileCountSpan.textContent = '1 arquivo selecionado';
    } else {
        fileCountSpan.textContent = fileCount + ' arquivos selecionados';
    }
});

const calendar = document.querySelector(".calendar"),
    date = document.querySelector(".date"),
    daysContainer = document.querySelector(".days"),
    prev = document.querySelector(".prev"),
    next = document.querySelector(".next"),
    todayBtn = document.querySelector(".today-btn"),
    gotoBtn = document.querySelector(".goto-btn"),
    dateInput = document.querySelector(".date-input"),
    eventDay = document.querySelector(".event-day"),
    eventDate = document.querySelector(".event-date"),
    eventsContainer = document.querySelector(".events"),
    addEventSubmit = document.querySelector(".add-event-btn");

let today = new Date();
let activeDay;
let month = today.getMonth();
let year = today.getFullYear();

const months = [
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
    "Novembro",
    "Dezembro",
];

//Eventos padrão
/*const eventsArr = [
    {
        day: 18,
        month: 4,
        year: 2024,
        events: [
            {
                title: "Event 1 lorem ipsun dolar sit genfa tersd dasd",
                time: "10:00 AM"
            },
            {
                title: "Event 2",
                time: "11:00 AM",
            },
        ],
    },
    {
        day: 22,
        month: 4,
        year: 2024,
        events: [
            {
                title: "Event 1 lorem ipsun dolar sit genfa tersd dasd",
                time: "10:00 AM"
            },
            {
                title: "Event 2",
                time: "11:00 AM",
            },
        ],
    }
];*/

//define um array vazio
let eventsArr = [];

//e em seguida chama o get
getEvents();

//função para adicionar dias

function initCalendar() {
    //função para adicionar dias no contêiner com a classe day, prev-date, next-date nos dias do mês anterior e próximo, e active no dia atual
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const prevLastDay = new Date(year, month, 0);
    const prevDays = prevLastDay.getDate();
    const lastDate = lastDay.getDate();
    const day = firstDay.getDay();
    const nextDays = 7 - lastDay.getDay() - 1;

    date.innerHTML = months[month] + " " + year;

    //adicionar dias

    let days = "";

    //dias do mês passado

    for (let x = day; x > 0; x--) {
        days += `<div class= "day prev-date" >${prevDays - x + 1}</div>`;
    }

    //quantidade de dias do mês atual

    for (let i = 1; i <= lastDate; i++) {

        //checa se há um evento no dia atual
        let event = false;
        eventsArr.forEach((eventObj) => {
            if (
                eventObj.day === i &&
                eventObj.month === month + 1 &&
                eventObj.year === year
            ) {
                //se o evento for encontrado
                event = true;
            }
        });

        //se o dia é hoje adicione a classe today
        if (i === new Date().getDate()
            && year === new Date().getFullYear()
            && month === new Date().getMonth()) {

            activeDay = i;
            getActiveDay(i);
            updateEvents(i);
            //se event for encontrado, adicione a classe event
            //adiciona 'active' no dia de hoje quando inicializado
            if (event) {
                days += `<div class="day today active event">${i}</div>`;
            }
            else {
                days += `<div class="day today active">${i}</div>`;
            }
        }
        //adiciona o resto dos dias
        else {
            if (event) {
                days += `<div class="day event">${i}</div>`;
            }
            else {
                days += `<div class="day">${i}</div>`;
            }
        }
    }

    //dias do próximo mês
    for (let j = 1; j <= nextDays; j++) {
        days += `<div class="day next-date" >${j}</div>`;
    }

    daysContainer.innerHTML = days;
    //adiciona listener depois que o calendário é inicializado
    addListener();
}

initCalendar();

//mês passado
function prevMonth() {
    month--;
    if (month < 0) {
        month = 11;
        year--;
    }
    initCalendar();
}

//próximo mês
function nextMonth() {
    month++;
    if (month > 11) {
        month = 0;
        year++;
    }
    initCalendar();
}

//executa a função quando houver o clique

prev.addEventListener("click", prevMonth);
next.addEventListener("click", nextMonth);

// calendário está pronto
//adicionar 'vá para data especificada' e 'vá para hoje'

todayBtn.addEventListener("click", () => {
    today = new Date();
    month = today.getMonth();
    year = today.getFullYear();
    initCalendar();
});

dateInput.addEventListener("input", (e) => {
    //permite somente números e remove o resto
    dateInput.value = dateInput.value.replace(/[^0-9/]/g, "");
    if (dateInput.value.length === 2) {
        //adiciona a '/' depois de dois números digitados
        dateInput.value += '/';
    }
    if (dateInput.value.length > 7) {
        //não permite mais de 7 caracteres
        dateInput.value = dateInput.value.slice(0, 7);
    }

    //se o backspace for pressionado
    if (e.inputType === "deleteContentBackward") {
        if (dateInput.value.length === 3) {
            dateInput.value = dateInput.value.slice(0, 2);
        }
    }
});

gotoBtn.addEventListener("click", gotoDate);

//ir para a data digitada
function gotoDate() {
    const dateArr = dateInput.value.split("/");

    //validação da data
    if (dateArr.length === 2) {
        if (dateArr[0] > 0 && dateArr[0] < 13 && dateArr[1].length === 4) {
            month = dateArr[0] - 1;
            year = dateArr[1];
            initCalendar();
            return;
        }
    }

    //se a data for inválida
    alert("Data inválida");
}

const addEventBtn = document.querySelector(".add-event"),
    addEventContainer = document.querySelector(".add-event-wrapper"),
    addEventCloseBtn = document.querySelector(".close"),
    addEventTitle = document.querySelector(".event-name"),
    addEventFrom = document.querySelector(".event-time-from"),
    addEventTo = document.querySelector(".event-time-to");

addEventBtn.addEventListener("click", () => {
    addEventContainer.classList.toggle("active");
});

addEventCloseBtn.addEventListener("click", () => {
    addEventContainer.classList.remove("active");
});

document.addEventListener("click", (e) => {
    //se clicar fora (da caixa) fechar ela
    if (e.target !== addEventBtn && !addEventContainer.contains(e.target)) {
        addEventContainer.classList.remove("active");
    }
});

//permite apenas 50 caracteres no título
addEventTitle.addEventListener("input", (e) => {
    addEventTitle.value = addEventTitle.value.slice(0, 50);
});

//formatação do tempo (EventFrom)
addEventFrom.addEventListener("input", (e) => {
    //remove tudo que não for números
    addEventFrom.value = addEventFrom.value.replace(/[^0-9:]/g, "");
    //após dois números digitados, acrescente ':'
    if (addEventFrom.value.length === 2) {
        addEventFrom.value += ':';
    }

    //não permite o usuário digitar mais de 4 números (+1 dos dois pontos)
    if (addEventFrom.value.length > 5) {
        addEventFrom.value = addEventFrom.value.slice(0, 5);
    }
});

// formatação do tempo (EventTo)
addEventTo.addEventListener("input", (e) => {
    // remove tudo que não for números
    addEventTo.value = addEventTo.value.replace(/[^0-9:]/g, "");
    // após dois números digitados, acrescente ':'
    if (addEventTo.value.length === 2) {
        addEventTo.value += ':';
    }
    // não permite que o usuário digite mais de 5 caracteres
    if (addEventTo.value.length > 5) {
        addEventTo.value = addEventTo.value.slice(0, 5);
    }
});

// função para adicionar listener em dias após serem renderizados
function addListener() {
    const days = document.querySelectorAll(".day");
    days.forEach((day) => {
        day.addEventListener("click", (e) => {
            // define o dia ativo como o dia clicado
            activeDay = Number(e.target.innerHTML);

            // chama getActiveDay após o clique
            getActiveDay(e.target.innerHTML);
            updateEvents(Number(e.target.innerHTML));

            // remove a classe 'active' do dia ativo anterior
            days.forEach((day) => {
                day.classList.remove('active');
            });

            // se clicar em um dia do mês anterior, vai para o mês anterior e adiciona a classe 'active'
            if (e.target.classList.contains("prev-date")) {
                prevMonth();
                setTimeout(() => {
                    // seleciona todos os dias deste mês
                    const days = document.querySelectorAll(".day");

                    // após ir para o mês anterior, adiciona a classe 'active' ao dia clicado
                    days.forEach((day) => {
                        if (!day.classList.contains("prev-date") && day.innerHTML === e.target.innerHTML) {
                            day.classList.add("active");
                        }
                    });
                }, 100);
            } 
            // mesma coisa para dias do próximo mês
            else if (e.target.classList.contains("next-date")) {
                nextMonth();
                setTimeout(() => {
                    // seleciona todos os dias deste mês
                    const days = document.querySelectorAll(".day");

                    // após ir para o próximo mês, adiciona a classe 'active' ao dia clicado
                    days.forEach((day) => {
                        if (!day.classList.contains("next-date") && day.innerHTML === e.target.innerHTML) {
                            day.classList.add("active");
                        }
                    });
                }, 100);
            }

            // adiciona a classe 'active' aos dias restantes do mês atual
            e.target.classList.add("active");
        });
    });
}

// mostra o dia e a data do evento no topo
function getActiveDay(date) {
    const day = new Date(year, month, date);
    const dayName = day.toString().split(" ")[0];
    eventDay.innerHTML = dayName;
    eventDate.innerHTML = date + ' ' + months[month] + ' ' + year;
}

// função para mostrar eventos de um dia específico
function updateEvents(date) {
    let events = "";
    eventsArr.forEach((event) => {
        // pega eventos apenas dos dias ativos
        if (date === event.day && month + 1 === event.month && year === event.year) {
            // mostra os eventos no documento
            event.events.forEach((event) => {
                events += `
                <div class="event">
                    <div class="title">
                        <i class="fas fa-circle"></i>
                        <h3 class="event-title">${event.title}</h3>
                    </div>
                    <div class="event-time">
                        <span class="event-time">${event.time}</span>
                    </div>
                </div>`;
            });
        }
    });

    // se nenhum evento for encontrado
    if (events === "") {
        events = `
        <div class="no-event">
            <h3>Sem Eventos</h3>
        </div>`;
    }

    eventsContainer.innerHTML = events;
    // salva um evento quando updateEvents for chamado
    saveEvents();
}

// função para adicionar eventos
addEventSubmit.addEventListener("click", () => {
    const eventTitle = addEventTitle.value;
    const eventTimeFrom = addEventFrom.value;
    const eventTimeTo = addEventTo.value;

    // algumas validações
    if (eventTitle === "" || eventTimeFrom === "" || eventTimeTo === "" || fileCount < 1) {
        alert("Por favor, preencha todos os campos");
        return;
    }

    const timeFromArr = eventTimeFrom.split(":");
    const timeToArr = eventTimeTo.split(":");

    if (timeFromArr.length != 2 || timeToArr.length != 2 || timeFromArr[0] > 23 || timeFromArr[1] > 59 || timeToArr[0] > 23 || timeToArr[1] > 59) {
        alert("Formato de Hora Inválido");
        return;
    }

    const timeFrom = convertTime(eventTimeFrom);
    const timeTo = convertTime(eventTimeTo);

    const newEvent = {
        title: eventTitle,
        time: timeFrom + " - " + timeTo,
    };

    let eventAdded = false;
    // verifica se eventsArr não está vazio
    if (eventsArr.length > 0) {
        // verifica se o dia ativo já tem um evento e adiciona a ele
        eventsArr.forEach((item) => {
            if (item.day === activeDay && item.month === month + 1 && item.year === year) {
                item.events.push(newEvent);
                eventAdded = true;
            }
        });
    }

    // se eventsArr está vazio ou o dia ativo não possui eventos, cria um novo
    if (!eventAdded) {
        eventsArr.push({
            day: activeDay,
            month: month + 1,
            year: year,
            events: [newEvent],
        });
    }

    // remove a classe 'active' do formulário de adicionar evento
    addEventContainer.classList.remove('active');
    // limpa os campos
    addEventTitle.value = "";
    addEventFrom.value = "";
    addEventTo.value = "";

    // mostra o evento recém-adicionado
    updateEvents(activeDay);

    // adiciona a classe 'event' para o novo evento criado (se não adicionado)
    const activeDayElem = document.querySelector(".day.active");
    if (!activeDayElem.classList.contains("event")) {
        activeDayElem.classList.add("event");
    }
});

function convertTime(time) {
    let timeArr = time.split(":");
    let timeHour = timeArr[0];
    let timeMin = timeArr[1];
    let timeFormat = timeHour >= 12 ? "PM" : "AM";
    timeHour = timeHour % 12 || 12;
    time = timeHour + ":" + timeMin + " " + timeFormat;
    return time;
}

function openEventDialog(eventInfo) {
    const dialog = document.getElementById('event-dialog');
    const eventDetails = document.getElementById('event-details');
    eventDetails.innerText = eventInfo;
    dialog.style.display = 'block';

    const closeBtn = document.getElementsByClassName('close-dialog')[0];
    closeBtn.onclick = function () {
        dialog.style.display = 'none';
    };

    window.onclick = function (event) {
        if (event.target === dialog) {
            dialog.style.display = 'none';
        }
    };
}

eventsContainer.addEventListener("click", (e) => {
    if (e.target.classList.contains("event")) {
        const eventInfo = e.target.innerText;
        openEventDialog(eventInfo);
    }
});

// armazenar eventos no histórico local
function saveEvents() {
    localStorage.setItem("events", JSON.stringify(eventsArr));
}

function getEvents() {
    if (localStorage.getItem("events") === null) {
        return;
    }
    eventsArr.push(...JSON.parse(localStorage.getItem("events")));
}


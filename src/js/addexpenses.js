import Alert from './Alert.js'

const {today,yesterday} = {
    today: document.querySelector('#pick-today'), // BUTTON TO PICK TODAY'S DATE
    yesterday: document.querySelector('#pick-yesterday'), // BUTTON TO PICK YESTERDAY'S DATE
}
const description = document.querySelector('#description') // DESCRIPTION INPUT
const descriptionCount = document.querySelector('#description-count') // DESCRIPTION CHARACTER COUNT
const dateInput = document.querySelector('#date') // DATE INPUT

// PICK TODAY'S DATE
const pickToday = (e) => {
    e.preventDefault()
    const today = new Date()
    dateInput.value = today.toISOString().split('T')[0]
}

// PICK YESTERDAY'S DATE
const pickYesterday = (e) => {
    e.preventDefault()
    const yesterday = new Date()
    yesterday.setDate(yesterday.getDate() - 1)
    dateInput.value = yesterday.toISOString().split('T')[0]
}

// COUNT THE CHARACTERS IN THE DESCRIPTION INPUT
description.addEventListener('input',(e) => {
    const descriptionLength = e.target.value.length
    
    if(descriptionLength >= 15){
        // stop user from typing
        e.target.value = e.target.value.slice(0,15)
    }
    descriptionCount.textContent = e.target.value.length
})

// EVENT LISTENERS

today.addEventListener('click', pickToday) // PICK TODAY'S DATE WHEN CLICKED
yesterday.addEventListener('click', pickYesterday) // PICK YESTERDAY'S DATE WHEN CLICKED

// CHECK IF DATE IS PAST TODAY'S DATE
dateInput.addEventListener('change', (e) => {
    const date = new Date(e.target.value)
    const today = new Date()
    if(date > today){
        const modal = new Alert();
        modal.alertBox('Date cannot be in the future')
        
        e.target.value = today.toISOString().split('T')[0]
    }
})
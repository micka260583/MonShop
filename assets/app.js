import noUiSlider from 'nouislider';
import './styles/app.css';

console.log('hello you');



const slider = document.getElementById('price-slider');

if (slider) {
    noUiSlider.create(slider, {
    start: [20, 80],
    connect: true,
    range: {
        'min': 0,
        'max': 100
    }
});
}


import {CountUp} from "countup.js";
import { Odometer } from 'odometer_countup';
document.addEventListener('DOMContentLoaded', function () {


    // Elements
    const numberCodeForm = document.querySelector('[data-number-code-form]');
    const numberCodeInputs = [...numberCodeForm.querySelectorAll('[data-number-code-input]')];
    const fetchButton = document.querySelector('[data-fetch-button]');

    // Variable to store the last four digits
    let lastFourDigits = [];

    async function compareWithApiData(lastFourDigits) {
        try {
            // Replace 'API_URL' with the actual URL of the API
            const response = await fetch('https://summer.xvision.ir/wp-json/excel-importer/v1/data/');
            const data = await response.json();

            // Array to store modified items with leading zeros in the id
            const modifiedItems = [];

            data.forEach(item => {
                const id = item.id.toString();
                const numberOfDigits = id.length;

                if (numberOfDigits === 1) {
                    item.id = '000' + id;
                } else if (numberOfDigits === 2) {
                    item.id = '00' + id;
                } else if (numberOfDigits === 3) {
                    item.id = '0' + id;
                }

                modifiedItems.push(item);
            });

            // Compare lastFourDigits with modified item.id
            // const contestContainer = document.getElementById('notice-contest');
            // if (lastFourDigits.join('') <= modifiedItems.length) {
            //     contestContainer.innerHTML = '.برنده پیدا شد'
            // } else {
            //     contestContainer.innerHTML = ` شماره شرکت کننده باید بین عدد 1 تا  ${modifiedItems.length} باشد`
            // }
            const foundItem = modifiedItems.find(item => item.id === lastFourDigits.join(''));

            if (foundItem) {
                const easingFn = function (t, b, c, d) {
                    var ts = (t /= d) * t;
                    var tc = ts * t;
                    return b + c * (tc * ts + -5 * ts * ts + 10 * tc + -10 * ts + 5 * t);
                }
                const options = {
                    formattingFn: (n) => {
                        return formatNumber(n);
                    },
                    startVal: 0,
                    easingFn,
                    plugin: new Odometer({ duration: 1.3 }),
                    separator: '',
                    prefix: '۰',
                    decimal: '',
                    numerals: ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
                };

                function formatNumber(num) {
                    const numAsString = num.toString();
                    if (numAsString.length >= 6) {
                        const firstThreeDigits = numAsString.substring(0, 3);
                        return '0' + firstThreeDigits + '***' + numAsString.substring(6);
                    }
                    return numAsString;
                }

                let demo = new CountUp('myTargetElement', foundItem.phone, options);
                console.log(foundItem.phone)
                if (!demo.error) {
                    demo.start();
                } else {
                    console.error(demo.error);
                }
                console.log("Success! Matching item found:", foundItem);
                // console.log('THE WINNERS NUMBER (First Three Digits):', finalFirstThreeDigits);
                // console.log('THE WINNERS NUMBER (Last Four Digits):', lastFourDigitsArray.join(''));
            } else {
                console.log("Not found. No matching item with last four digits:", lastFourDigits.join(''));
            }
        } catch (error) {
            console.error("Error fetching data from API:", error);
        }
    }
    // Function to check if all inputs have been filled
    function areAllInputsFilled() {
        return numberCodeInputs.every(input => input.value.length === 1);
    }

    // Event callbacks
    const handleInput = ({target}) => {
        if (!target.value.length) {
            return target.value = null;
        }

        const inputLength = target.value.length;
        let currentIndex = Number(target.dataset.numberCodeInput);

        if (inputLength > 1) {
            const inputValues = target.value.split('');
            inputValues.forEach((value, valueIndex) => {
                const nextValueIndex = currentIndex + valueIndex;

                if (nextValueIndex >= numberCodeInputs.length) {
                    return;
                }

                numberCodeInputs[nextValueIndex].value = value;
            });

            currentIndex += inputValues.length - 2;
        }

        const nextIndex = currentIndex + 1;

        if (nextIndex < numberCodeInputs.length) {
            numberCodeInputs[nextIndex].focus();
        }

        // Check if all inputs have been filled
        if (areAllInputsFilled()) {
            // Extract the last four digits and store them in the variable
            lastFourDigits = numberCodeInputs.slice(-4).map(input => parseInt(input.value));
        }
    };

    const handleFetchButtonClick = () => {
        // Fetch the API with the last four digits as the ID
        if (lastFourDigits.length === 4) {
            compareWithApiData(lastFourDigits);
        } else {
            console.log("Please fill all four digits before fetching the API.");
        }
    };

    // Event listeners
    numberCodeForm.addEventListener('input', handleInput);

    if (fetchButton) {
        fetchButton.addEventListener('click', handleFetchButtonClick);
    } else {
        console.error("Fetch button not found.");
    }

    const handleKeyDown = e => {
        const {code, target} = e;

        const currentIndex = Number(target.dataset.numberCodeInput);
        const previousIndex = currentIndex - 1;
        const nextIndex = currentIndex + 1;

        const hasPreviousIndex = previousIndex >= 0;
        const hasNextIndex = nextIndex <= numberCodeInputs.length - 1

        switch (code) {
            case 'ArrowLeft':
            case 'ArrowUp':
                if (hasPreviousIndex) {
                    numberCodeInputs[previousIndex].focus();
                }
                e.preventDefault();
                break;

            case 'ArrowRight':
            case 'ArrowDown':
                if (hasNextIndex) {
                    numberCodeInputs[nextIndex].focus();
                }
                e.preventDefault();
                break;
            case 'Backspace':
                if (!e.target.value.length && hasPreviousIndex) {
                    numberCodeInputs[previousIndex].value = null;
                    numberCodeInputs[previousIndex].focus();
                }
                break;
            default:
                break;
        }
    }
    numberCodeForm.addEventListener('keydown', handleKeyDown);



//     animation dots
    const element = document.querySelector('.element');
    const dotContainer = document.createElement('div');
    dotContainer.classList.add('dot-container');

    function createDots() {
        const numDots = 40;
        const perimeter = (element.offsetWidth + element.offsetHeight) * 2;
        const dotWidth = 20;
        const dotHeight = 10;
        const space = perimeter / numDots;

        for (let i = 0; i < numDots; i++) {
            const dot = document.createElement('div');
            dot.className = 'dot';
            const angle = (space * i) % perimeter;
            let x, y;

            if (angle < element.offsetWidth) {
                x = angle;
                y = 0;
            } else if (angle < element.offsetWidth + element.offsetHeight) {
                x = element.offsetWidth;
                y = angle - element.offsetWidth;
            } else if (angle < element.offsetWidth * 2 + element.offsetHeight) {
                x = element.offsetWidth - (angle - (element.offsetWidth + element.offsetHeight));
                y = element.offsetHeight;
            } else {
                x = 0;
                y = element.offsetHeight - (angle - (element.offsetWidth * 2 + element.offsetHeight));
            }

            x -= dotWidth / 2;
            y -= dotHeight / 2;

            dot.style.left = `${x}px`;
            dot.style.top = `${y}px`;
            dotContainer.appendChild(dot);

            // Add recursive blinking animation to both odd and even dots
            dot.style.animation = i % 2 === 0 ? 'blinkEven 5s infinite' : 'blinkOdd 5s infinite';
        }
    }

    element.appendChild(dotContainer);
    createDots();
});
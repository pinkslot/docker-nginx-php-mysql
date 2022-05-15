(() => {
    const fillState = ({money, bonuses}) => {

        document.getElementById('money-count').innerHTML = money;
        document.getElementById('bonuses-count').innerHTML = bonuses;
    }

    const button = document.getElementById('take-prize');
    button.addEventListener('click', () => {
        fetch('take-prize', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
            },
        }).then(response => response.json().then(data => fillState(data)))
    });

    fetch('state', {
        method: 'GET',
        headers: {
            'Content-type': 'application/json',
        },
    }).then(response => response.json().then(data => fillState(data)))
})();

export function afficherEasteregg() {
    // Select the div with the id 'loginArea'
    const loginArea = document.getElementById('loginArea');

    // Create a new img element
    const gifImage = document.createElement('img');

    // Set the src attribute to the path of the gif
    gifImage.src = 'img/doom.gif';

    // Append the img element to the loginArea div
    loginArea.appendChild(gifImage);
    // Create a modal container
    const modal = document.createElement('div');
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
    modal.style.display = 'flex';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';
    modal.style.zIndex = '1000';
    modal.style.visibility = 'hidden';

    // Append the gif image to the modal
    modal.appendChild(gifImage);

    // Append the modal to the body
    document.body.appendChild(modal);

    // Create a button to trigger the modal
    const triggerButton = document.createElement('a');
    triggerButton.textContent = 'Clique';
    triggerButton.style.marginTop = '10px';

    // Add an event listener to show the modal on button click
    triggerButton.addEventListener('click', () => {
        modal.style.visibility = 'visible';
    });

    // Add an event listener to hide the modal when clicked
    modal.addEventListener('click', () => {
        modal.style.visibility = 'hidden';
    });

    // Append the button to the loginArea
    loginArea.appendChild(triggerButton);
}
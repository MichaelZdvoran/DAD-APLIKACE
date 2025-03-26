function createTicket() {
  const title = document.getElementById('ticketTitle').value.trim();
  const description = document.getElementById('ticketDescription').value.trim();
  const zavaznost = document.getElementById('zavaznost').value;

  if (!title || !description || !zavaznost) {
    alert('Vyplňte všechna pole!');
    return;
  }

  const ticketDiv = document.createElement('div');
  ticketDiv.className = 'ticket';

  const titleEl = document.createElement('h3');
  titleEl.textContent = title;

  const descEl = document.createElement('p');
  descEl.textContent = description;

  const zavaznostEl = document.createElement('p');
  zavaznostEl.innerHTML = `<strong>Závažnost:</strong> ${zavaznost}`;

  const status = document.createElement('span');
  status.className = 'status';
  status.textContent = 'Odesláno';

  ticketDiv.appendChild(titleEl);
  ticketDiv.appendChild(descEl);
  ticketDiv.appendChild(zavaznostEl);
  ticketDiv.appendChild(status);

  document.getElementById('tickets').appendChild(ticketDiv);

  document.getElementById('ticketTitle').value = '';
  document.getElementById('ticketDescription').value = '';
  document.getElementById('zavaznost').value = '';
}

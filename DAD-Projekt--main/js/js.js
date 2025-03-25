function createTicket() {
    const title = document.getElementById('ticketTitle').value.trim();
    const description = document.getElementById('ticketDescription').value.trim();
    const email = document.getElementById('ticketEmail').value.trim();
  
    if (!title || !description || !email) {
      alert('Vyplňte všechna pole!');
      return;
    }
  
    const ticketDiv = document.createElement('div');
    ticketDiv.className = 'ticket';
  
    const titleEl = document.createElement('h3');
    titleEl.textContent = title;
  
    const descEl = document.createElement('p');
    descEl.textContent = description;
  
    const emailEl = document.createElement('p');
    emailEl.innerHTML = `<strong>Email:</strong> ${email}`;
  
    const status = document.createElement('span');
    status.className = 'status';
    status.textContent = 'Odesláno';
  
    ticketDiv.appendChild(titleEl);
    ticketDiv.appendChild(descEl);
    ticketDiv.appendChild(emailEl);
    ticketDiv.appendChild(status);
  
    document.getElementById('tickets').appendChild(ticketDiv);
  
    document.getElementById('ticketTitle').value = '';
    document.getElementById('ticketDescription').value = '';
    document.getElementById('ticketEmail').value = '';
  }
  
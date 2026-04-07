describe('Página de Jugadores', () => {

  const mockJugadores = [
    { id: 1, nombre: 'Ana López', posicion: 'Delantero', dorsal: 9, club_id: 1,
      club: { id: 1, nombre: 'CD Maestre', ciudad: 'Bolaños', categoria: 'Senior' } },
    { id: 2, nombre: 'Luis Ortega', posicion: 'Defensa', dorsal: 4, club_id: 1,
      club: { id: 1, nombre: 'CD Maestre', ciudad: 'Bolaños', categoria: 'Senior' } },
    { id: 3, nombre: 'María Ruiz', posicion: 'Portero', dorsal: 1, club_id: 2,
      club: { id: 2, nombre: 'Atlético Calatrava', ciudad: 'Calatrava', categoria: 'Junior' } }
  ];

  beforeEach(() => {
    cy.intercept('GET', '**/api/jugadors', mockJugadores).as('getJugadores');
  });

  it('debe mostrar la lista completa de jugadores', () => {
    cy.visit('/jugadores');
    cy.wait('@getJugadores');
    cy.get('.list-group-item').should('have.length', 3);
    cy.contains('.list-group-item', 'Ana López');
    cy.contains('.list-group-item', 'Luis Ortega');
    cy.contains('.list-group-item', 'María Ruiz');
  });

  it('debe filtrar jugadores por nombre', () => {
    cy.visit('/jugadores');
    cy.wait('@getJugadores');
    cy.get('#nombreFilter').type('Ana');
    cy.get('.list-group-item').should('have.length', 1);
    cy.contains('.list-group-item', 'Ana López');
  });

  it('debe filtrar por posición Defensa', () => {
    cy.visit('/jugadores');
    cy.wait('@getJugadores');
    cy.get('#positionFilter').select('Defensa');
    cy.get('.list-group-item').should('have.length', 1);
    cy.contains('.list-group-item', 'Luis Ortega');
  });

  it('debe mostrar un mensaje de error si la API falla', () => {
    cy.intercept('GET', '**/api/jugadors', {
      statusCode: 500,
      body: { error: 'Error del servidor' }
    }).as('getJugadoresError');

    cy.visit('/jugadores');
    cy.wait('@getJugadoresError');
    cy.get('.alert-danger').should('be.visible');
  });
});

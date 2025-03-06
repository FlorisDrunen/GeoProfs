describe('Verlof tests', () => {

    /**
     * Test if user can request verlof.
     */
    it('Request verlof', () => {
        cy.visit('/api/login');
    
        cy.get('input[name="email"]').type('Testmail@mail.com');
        cy.get('input[name="password"]').type('12345678');
    
        cy.get('button[type="submit"]').click();
    
        cy.url().should('eq', 'http://localhost:8080/api/dashboard');

        cy.get('a.dashboard-nav-link').contains('verlof aanvragen').click();

        cy.url().should('include', '/api/verlof-aanvraag');

        cy.get('input[name="begin_tijd"]').type('09:00'); 
        cy.get('input[name="begin_datum"]').type('2025-03-11'); 
        cy.get('input[name="eind_tijd"]').type('17:00'); 
        cy.get('input[name="eind_datum"]').type('2025-03-20'); 
        cy.get('textarea[name="reden"]').type('Vakantie'); 
        cy.get('input[name="status"]').should('have.value', 'pending'); 

        cy.contains('button', 'Aanvragen').click();

        cy.url().should('include', '/api/verlof-overzicht'); 

        cy.contains('Vakantie').should('exist');
      });

     /**
     * Test if user can edit their verlof request & logout.
     */

      it('Edit verlof & logout', () => {
        cy.visit('/api/login');
    
        cy.get('input[name="email"]').type('Testmail@mail.com');
        cy.get('input[name="password"]').type('12345678');
    
        cy.get('button[type="submit"]').click();
        cy.url().should('eq', 'http://localhost:8080/api/dashboard');

        cy.get('a.dashboard-nav-link').contains('verlof overzicht').click();
        cy.url().should('eq', 'http://localhost:8080/api/verlof-overzicht');

        cy.get('.verlof-table').first().click();
        cy.url().should('include', '/api/verlof/');

        cy.get('a.grey-button').contains('Bewerken').click();

        cy.url().should('include', '/verlof-update');

        cy.get('input[name="begin_tijd"]').clear().type('10:00');
        cy.get('input[name="begin_datum"]').clear().type('2025-03-05');
        cy.get('input[name="eind_tijd"]').clear().type('16:00');
        cy.get('input[name="eind_datum"]').clear().type('2025-03-06');
        cy.get('textarea[name="reden"]').clear().type('Nieuwe reden voor verlof');

        cy.get('button[type="submit"]').contains('Bijwerken').click();

        cy.url().should('include', '/api/verlof-overzicht');

        cy.contains('Nieuwe reden voor verlof').should('exist');

        cy.contains('button', 'Logout').click();
        cy.url().should('eq', 'http://localhost:8080/api/login');
      });

     /**
     * Test if the officemanager can accept and deny verlof requests.
     */

      it('accept & deny request', () => {
        cy.visit('/api/login');
    
        cy.get('input[name="email"]').type('adminGeoprofs@mail.com');
        cy.get('input[name="password"]').type('12345678');
    
        cy.get('button[type="submit"]').click();
        cy.url().should('eq', 'http://localhost:8080/api/dashboard');

        cy.get('a.dashboard-nav-link').contains('verlof overzicht').click();
        cy.url().should('eq', 'http://localhost:8080/api/verlof-overzicht');

        cy.get('.verlof-table').first().click();
        cy.url().should('include', '/api/verlof/');

        cy.get('button[type="submit"]').contains('Goedkeuren').click();
        cy.url().should('include', '/api/verlof/');
        cy.get('.verlof-table-item').contains('Status').parent().contains('approved').should('exist');    

        cy.get('.verlof-table').first().click();
        cy.url().should('include', '/api/verlof/');

        cy.get('button[type="submit"]').contains('Afwijzen').click();
        cy.url().should('include', '/api/verlof/');
        cy.get('.verlof-table-item').contains('Status').parent().contains('denied').should('exist');    

      });

     /**
     * Test if user can delete the (by office manager) denied request.
     */
      
      it('delete denied verlof', () => {
        cy.visit('/api/login');
    
        cy.get('input[name="email"]').type('Testmail@mail.com');
        cy.get('input[name="password"]').type('12345678');
    
        cy.get('button[type="submit"]').click();
        cy.url().should('eq', 'http://localhost:8080/api/dashboard');

        cy.get('a.dashboard-nav-link').contains('verlof overzicht').click();
        cy.url().should('eq', 'http://localhost:8080/api/verlof-overzicht');

        cy.get('#statusFilter').select('denied');
        cy.get('.verlof-table-item').contains('Status').parent().contains('denied').should('exist');    

        cy.get('.verlof-table').first().click();
        cy.url().should('include', '/api/verlof/');

        cy.get('button[type="submit"]').contains('Verwijderen').click();

        cy.url().should('include', '/api/verlof-overzicht');
      });
  });
  
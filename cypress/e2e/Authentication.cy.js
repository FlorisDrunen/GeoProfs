describe('Login Test met Database Seeding', () => {
  it('Seed database', () => {
    // 1. Voer het seed commando uit
    cy.exec('cd ./src/backend && docker compose exec backend php artisan db:seed --class=OfficemanagerSeeder')
      .then((result) => {
        expect(result.code).to.eq(0); // Controleer of seeding succesvol was
      });
    });
    // 2. Ga naar de loginpagina
    it('login as Officemanager', () => {
    cy.visit('/api/login');

    // 3. Vul de inloggegevens in
    cy.get('input[name="email"]').type('adminGeoprofs@mail.com');
    cy.get('input[name="password"]').type('12345678');

    // 4. Klik op de login-knop
    cy.get('button[type="submit"]').click();

    // 5. Controleer of de gebruiker naar /api/dashboard wordt doorgestuurd
    cy.url().should('eq', 'http://localhost:8080/api/dashboard');
  });

  it('register new user and logout', () => {
    cy.visit('/api/login');

    // 3. Vul de inloggegevens in
    cy.get('input[name="email"]').type('adminGeoprofs@mail.com');
    cy.get('input[name="password"]').type('12345678');

    // 4. Klik op de login-knop
    cy.get('button[type="submit"]').click();

    // 5. Controleer of de gebruiker naar /api/dashboard wordt doorgestuurd
    cy.url().should('eq', 'http://localhost:8080/api/dashboard');
    cy.get('a.dashboard-button').contains('Register').click();
    cy.url().should('eq', 'http://localhost:8080/api/register');

    cy.get('input[name="first_name"]').type('Test');
    cy.get('input[name="last_name"]').type('User');
    cy.get('input[name="email"]').type('Testmail@mail.com');
    cy.get('select[name="rol"]').select('werknemer');
    cy.get('input[name="password"]').type('12345678');
    cy.get('input[name="password_confirmation"]').type('12345678');

    cy.get('button[type="submit"]').click();
    cy.url().should('eq', 'http://localhost:8080/api/dashboard');

    cy.get('a.dashboard-button').contains('Logout').should('be.visible').click();
    cy.url().should('eq', 'http://localhost:8080/api/login');
  });

  it('login as test user', () => {
    cy.visit('/api/login');

    cy.get('input[name="email"]').type('Testmail@mail.com');
    cy.get('input[name="password"]').type('12345678');

    cy.get('button[type="submit"]').click();

    cy.url().should('eq', 'http://localhost:8080/api/dashboard');
  });

});

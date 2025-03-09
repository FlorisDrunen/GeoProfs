describe('Authentication tests', () => {

    /**
     * refresh databse
     */
  before(() => {
    cy.exec('cd ./src/backend && docker compose exec backend php artisan migrate:refresh --seed')
      .then((result) => {
        expect(result.code).to.eq(0);
      });
  });
      /**
     * Seed database to get the admin user.
     */
  it('Seed database', () => {
    cy.exec('cd ./src/backend && docker compose exec backend php artisan db:seed --class=OfficemanagerSeeder')
      .then((result) => {
        expect(result.code).to.eq(0); 
      });
    });
    
     /**
     * Test if user can login as the officemanager.
     */
    it('login as Officemanager', () => {
    cy.visit('/api/login');

    cy.get('input[name="email"]').type('adminGeoprofs@mail.com');
    cy.get('input[name="password"]').type('12345678');

    cy.get('button[type="submit"]').click();

    cy.url().should('eq', 'http://localhost:8080/api/dashboard');
  });

      /**
     * Test if the officemanager can access the register page and create a user. Test if user can logout.
     */

  it('register new user and logout', () => {
    cy.visit('/api/login');

    cy.get('input[name="email"]').type('adminGeoprofs@mail.com');
    cy.get('input[name="password"]').type('12345678');

    cy.get('button[type="submit"]').click();

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

    cy.contains('button', 'Logout').click();
    cy.url().should('eq', 'http://localhost:8080/api/login');
  });

      /**
     * Test if user can login as the previously made user.
     */
  it('login as test user', () => {
    cy.visit('/api/login');

    cy.get('input[name="email"]').type('Testmail@mail.com');
    cy.get('input[name="password"]').type('12345678');

    cy.get('button[type="submit"]').click();

    cy.url().should('eq', 'http://localhost:8080/api/dashboard');
  });

});

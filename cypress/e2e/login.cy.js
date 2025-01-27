describe('Login Tests', () => {
    // Test 1: Controleer of de loginpagina wordt weergegeven
    it('shows the login page', () => {
      cy.visit('/login'); 
      cy.contains('Login'); 
    });
  
    // Test 2: Succesvol inloggen met juiste gegevens
    it('logs in with correct email and password', () => {
      cy.visit('/login');
  
      cy.get('input[name="email"]').type('user@example.com');
      cy.get('input[name="password"]').type('password123'); 
      cy.get('button[type="submit"]').click(); 
      cy.url().should('include', '/home'); 
      cy.contains('Welcome, User!');
    });
  
    // Test 3: Inloggen met fout e-mailadres
    it('fails to log in with incorrect email', () => {
      cy.visit('/login');
  
      cy.get('input[name="email"]').type('wrong@example.com'); 
      cy.get('input[name="password"]').type('password123'); 
      cy.get('button[type="submit"]').click(); 
  
      cy.contains('These credentials do not match our records.'); 
    });
  
    // Test 4: Inloggen met fout wachtwoord
    it('fails to log in with incorrect password', () => {
      cy.visit('/login');
  
      cy.get('input[name="email"]').type('user@example.com'); 
      cy.get('input[name="password"]').type('wrongpassword'); 
      cy.get('button[type="submit"]').click(); 
  
      cy.contains('These credentials do not match our records.'); 
    });
  
    // Test 5: Uitloggen
    it('logs out successfully', () => {
      
      cy.visit('/login');
      cy.get('input[name="email"]').type('user@example.com');
      cy.get('input[name="password"]').type('password123');
      cy.get('button[type="submit"]').click();
  
      
      cy.get('button.logout').click(); 
  
      cy.url().should('include', '/login'); 
      cy.contains('Login'); 
    });
  });
  
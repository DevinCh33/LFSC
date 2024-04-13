describe('Cart spec', () => {
  beforeEach(() => {
    cy.fixture('path.json').then((data) => {
      cy.visit(data.root + 'login.php')
    cy.get('input').first().type('cust1')
    cy.get('input').eq(1).type('123456')
    cy.get('input').last().click()
    cy.visit(data.root + 'dishes.php?res_is=51')
    })
  })
  it('Successfully loads products', () => {
    cy.get('div.food-item').should('exist')
  })
  it('Adds product to cart', () => {
    cy.get('.addsToCart').first().click()
    cy.get('#cartItems').find('li').first().should('exist')
  })
  it('Discount is correct', function() {
    cy.get('.product').eq(2).find('p.price').then((base) => {
      const price = parseFloat(base.text().replace('RM', ''))
      
      cy.get('.product').eq(2).find('div').then((disc) => {
        const discount = parseFloat(disc.text().replace('% off', ''))/100

        cy.get('.product').eq(2).find('span').should('have.text', 'RM ' + (price*(1-discount)).toFixed(2))
      })
    })
  })
  it('Check difference between first and second product', () => {
    cy.get('.product').eq(1).find('span').last().then((base) => {
      const price_old = parseFloat(base.text().replace('RM', ''))

      cy.get('.shiftOptions').first().click().then(() => {
        cy.get('.product').eq(1).find('span').last().then((base) => {
          const price_new = parseFloat(base.text().replace('RM', ''))
    
          expect(price_new).to.not.eq(price_old)
        })
      })
    })
  })
  it('Check discount of third product', () => {
    cy.get('.shiftOptions').first().click()
    cy.get('.shiftOptions').first().click()
    cy.get('.product').eq(1).find('p.price').then((base) => {
      const price = parseFloat(base.text().replace('RM', ''))
      
      cy.get('.product').eq(1).find('div').then((disc) => {
        const discount = parseFloat(disc.text().replace('% off', ''))/100

        cy.get('.product').eq(1).find('span').last().should('have.text', 'RM ' + (price*(1-discount)).toFixed(2))
      })
    })
  })
})
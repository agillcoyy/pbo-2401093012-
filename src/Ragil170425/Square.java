/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil170425;

/**
 *
 * @author Muhamad Soleh
 */
class Square extends Shape {
    private double side;

    public Square(double side) {
        this.side = side;
    }

    @Override
    double getArea() {
        return side * side;
    }

    @Override
    String getName() {
        return "Persegi";
    }

    public double getPerimeter() {
        return 4 * side;
    }
}


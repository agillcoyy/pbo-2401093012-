/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil170425;

/**
 *
 * @author Muhamad Soleh
 */
class Circle extends Shape {
    private double radius;

    public Circle(double radius) {
        this.radius = radius;
    }

    @Override
    double getArea() {
        return Math.PI * radius * radius;
    }

    @Override
    String getName() {
        return "Lingkaran";
    }

    public double getCircumference() {
        return 2 * Math.PI * radius;
    }
}


/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil170425;

/**
 *
 * @author Muhamad Soleh
 */
public class ExampleAbstract {
    public static void main(String[] args) {
        Shape circle = new Circle(7);
        Shape square = new Square(5);

        System.out.println(circle.getName() + " - Luas: " + circle.getArea());
        System.out.println(square.getName() + " - Luas: " + square.getArea());

        Circle specificCircle = (Circle) circle;
        Square specificSquare = (Square) square;

        System.out.println("Keliling Lingkaran: " + specificCircle.getCircumference());
        System.out.println("Keliling Persegi: " + specificSquare.getPerimeter());
    }
}


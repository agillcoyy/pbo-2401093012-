/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil150425;

/**
 *
 * @author Muhamad Soleh
 */
public class ExampleAbstract {
    public static void main(String[] args){
       
        Human human = new Human();
        human.breath();
        human.eat();
        human.walk();
        
        Horse horse = new Horse();
        horse.breath();
        horse.eat();
        horse.walk();
    }
}

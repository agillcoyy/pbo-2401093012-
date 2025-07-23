/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil110325;

/**
 *
 * @author Muhamad Soleh
 */
public class ContohIf {
    public static void main (String[] args){
        double grade = 92.0;
        if (grade >= 90) {
            System.out.println("Exelent");
        }
        else if (grade < 90) {
            System.out.println("Good Job!");
        }
        else if (grade < 80) {
            System.out.println("Study Harder!");
        }
        else {
            System.out.println("Sorry, You Failed.");
        }
    }
}

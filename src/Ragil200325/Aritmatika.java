/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil200325;

/**
 *
 * @author Muhamad Soleh
 */
public class Aritmatika {
    public static void main(String[] args) {
        
        if (args.length != 1) {
            System.out.println("Usage: java OddAndFibonacci <number>");
            return;
        }

        try {
            
            int number = Integer.parseInt(args[0]);

            System.out.println("Status ganjil (true/false) hingga " + number + ":");
            printOddStatus(number);

            System.out.println("\nBilangan Fibonacci hingga " + number + ":");
            printFibonacciNumbers(number);

        } catch (NumberFormatException e) {
            System.out.println("Error: Please enter a valid integer as input.");
        }
    }

    // Fungsi true/false bilangan ganjil
    public static void printOddStatus(int limit) {
        for (int i = 1; i <= limit; i++) {
            System.out.println(i + " -> " + isOdd(i));
        }
    }

    // Fungsi boolean bilangan ganjil
    public static boolean isOdd(int number) {
        return number % 2 != 0;
    }

    // Fungsi bilangan Fibonacci
    public static void printFibonacciNumbers(int limit) {
        int a = 0, b = 1;
        while (a <= limit) {
            System.out.print(a + " ");
            int next = a + b;
            a = b;
            b = next;
        }
    }
}

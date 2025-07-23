/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil170425;

/**
 *
 * @author Muhamad Soleh
 */
public class ComputerStudentRecord extends StudentRecord {
    private final String programmingLanguage;
    private final int experienceYears;

    public ComputerStudentRecord(String name, int age, String grade, String programmingLanguage, int experienceYears) {
        super(name, age, grade);
        this.programmingLanguage = programmingLanguage;
        this.experienceYears = experienceYears;
    }

    @Override
    public void displayRecord() {
        super.displayRecord();
        System.out.println("Bahasa Pemrograman Favorit: " + programmingLanguage);
        System.out.println("Pengalaman Coding: " + experienceYears + " tahun");
    }
}

